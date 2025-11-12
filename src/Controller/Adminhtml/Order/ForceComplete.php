<?php

/**
 * August Ash Force Order Complete Status Module
 *
 * @author    Peter McWilliams <pmcwilliams@augustash.com>
 * @copyright 2022 August Ash, Inc. (https://www.augustash.com)
 */

namespace Augustash\ForceComplete\Controller\Adminhtml\Order;

use Magento\Framework\App\Action\HttpPostActionInterface as HttpPostActionInterface;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Message\ManagerInterface as MessageManagerInterface;
use Magento\Framework\Phrase;
use Magento\Sales\Api\OrderRepositoryInterface;
use Magento\Sales\Model\Order as OrderModel;
use Magento\Sales\Model\ResourceModel\Order\CollectionFactoryInterface;
use Magento\Ui\Component\MassAction\Filter as UiFilter;

/**
 * Force complete sales order mass action class.
 */
class ForceComplete implements HttpPostActionInterface
{
    /**
     * Constructor.
     *
     * Initialize class dependencies.
     *
     * @param \Magento\Framework\Message\ManagerInterface $messageManager
     * @param \Magento\Sales\Model\ResourceModel\Order\CollectionFactoryInterface $orderCollectionFactory
     * @param \Magento\Sales\Api\OrderRepositoryInterface $orderRepository
     * @param \Magento\Framework\Controller\ResultFactory $resultFactory
     * @param \Magento\Ui\Component\MassAction\Filter $uiFilter
     */
    public function __construct(
        protected MessageManagerInterface $messageManager,
        protected CollectionFactoryInterface $orderCollectionFactory,
        protected OrderRepositoryInterface $orderRepository,
        protected ResultFactory $resultFactory,
        protected UiFilter $uiFilter,
    ) {
    }

    /**
     * Execute action based on request and return result.
     *
     * @return \Magento\Framework\Controller\ResultInterface|ResponseInterface
     * @throws \Magento\Framework\Exception\NotFoundException
     */
    public function execute()
    {
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
        $orderCount = 0;

        try {
            /** @var \Magento\Sales\Model\ResourceModel\Order\Collection $collection */
            $orderCollection = $this->uiFilter->getCollection($this->orderCollectionFactory->create());

            foreach ($orderCollection as $order) {
                /** @var \Magento\Sales\Model\Order $order */
                $order
                    ->setState(OrderModel::STATE_COMPLETE)
                    ->setStatus(OrderModel::STATE_COMPLETE);
                $this->orderRepository->save($order);
                $orderCount++;
            }

            $this->messageManager->addSuccessMessage(
                __('%1 order(s) of %2 were force completed.', $orderCount, $orderCollection->getSize())
            );

            $resultRedirect->setPath('sales/order/');
        } catch (LocalizedException $e) {
            $this->messageManager->addErrorMessage($e->getMessage());
            $resultRedirect->setPath('*/*/');
        } catch (\Exception $e) {
            $this->messageManager->addExceptionMessage(
                $e,
                new Phrase('Something went wrong while force completing the order(s).')
            );
            $resultRedirect->setPath('*/*/');
        }

        return $resultRedirect;
    }
}
