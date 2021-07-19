<?php
/**
 * Created By : Rohan Hapani
 */
namespace Vgroup\SafetyHubApp\Controller\Adminhtml\Dashboard;
use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\App\ResponseInterface;
class RefundedReport extends \Magento\Framework\App\Action\Action
{
    /**
     * @var \Magento\Framework\App\Response\Http\FileFactory
     */
    protected $fileFactory;
    /**
     * @var \Magento\Catalog\Model\ProductFactory
     */
    protected $productFactory;
    /**
     * @var \Magento\Framework\View\Result\LayoutFactory
     */
    protected $resultLayoutFactory;
    /**
     * @var \Magento\Framework\File\Csv
     */
    protected $csvProcessor;
    /**
     * @var \Magento\Framework\App\Filesystem\DirectoryList
     */
    protected $directoryList;
    /**
     * @param \Magento\Framework\App\Action\Context            $context
     * @param \Magento\Framework\App\Response\Http\FileFactory $fileFactory
     * @param \Magento\Catalog\Model\ProductFactory            $productFactory
     * @param \Magento\Framework\View\Result\LayoutFactory     $resultLayoutFactory
     * @param \Magento\Framework\File\Csv                      $csvProcessor
     * @param \Magento\Framework\App\Filesystem\DirectoryList  $directoryList
     */
	 	protected $_date;
    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Magento\Framework\App\Response\Http\FileFactory $fileFactory,
        \Magento\Catalog\Model\ProductFactory $productFactory,
        \Magento\Framework\View\Result\LayoutFactory $resultLayoutFactory,
        \Magento\Framework\File\Csv $csvProcessor,
		\Vgroup\SafetyHubApp\Model\CustomerFactory $customerFactory,// This is returns Collaction of Data
		\Magento\Framework\Stdlib\DateTime\TimezoneInterface $date,
        \Magento\Framework\App\Filesystem\DirectoryList $directoryList
    ) {
        $this->fileFactory = $fileFactory;
        $this->productFactory = $productFactory;
        $this->resultLayoutFactory = $resultLayoutFactory;
        $this->csvProcessor = $csvProcessor;
        $this->directoryList = $directoryList;
		$this->_customerFactory = $customerFactory;
		$this->_date =  $date;
        parent::__construct($context);
    }
    /**
     * Excel File Create and Download
     *
     * @return ResponseInterface
     * @throws \Magento\Framework\Exception\FileSystemException
     */
    public function execute()
    {
        /** Add yout header name here */
        $content[] = [
            //'entity_id' => __('FAO SAFETYHUB APP'),
            'enterprise'=>__('Enterprise App User'),
            'standard'=>__('Standard App User'),
            'totalAppuser'=>'Total App User'
            
        ];
		
	$objectManager = \Magento\Framework\App\ObjectManager::getInstance(); // Instance of object manager
			$resource = $objectManager->get('Magento\Framework\App\ResourceConnection');
			$connection = $resource->getConnection();
			$tableName = $resource->getTableName('employee'); //gives table name with prefix

			//Select Data from table
			$sql = "SELECT count(*) as total_user FROM customer_entity c where c.group_id=4 ";
			$result = $connection->fetchAll($sql); // gives associated array, table fields as key in array.
			$sql1 = "SELECT count(*) as total_user FROM customer_entity c, safetyhubapp_customer_permission sc where c.group_id=4 and c.entity_id=sc.customer_id and sc.company_id>0";
			$resultEnterise = $connection->fetchAll($sql1); // gives associated array, table fields as key in array.

                       
  
        $fileName = 'SafteyHubApp-Users.csv'; // Add Your CSV File name
        $filePath =  $this->directoryList->getPath(DirectoryList::MEDIA) . "/" . $fileName;
      
		$content[] = [
			'enterprise'=>$resultEnterise[0]['total_user'],
                    'standard'=>($result[0]['total_user']-$resultEnterise[0]['total_user']),
                    'totalAppuser'=>$result[0]['total_user'],
                       // $resultEnterise[0]['total_user']
		];
        
        $this->csvProcessor->setEnclosure('"')->setDelimiter(',')->saveData($filePath, $content);
        return $this->fileFactory->create(
            $fileName,
            [
                'type'  => "filename",
                'value' => $fileName,
                'rm'    => true, // True => File will be remove from directory after download.
            ],
            DirectoryList::MEDIA,
            'text/xls',
            null
        );
    }
}