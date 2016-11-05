<?php
namespace app\modules\admin\models;


include '/../vendor/phpppt/Classes/PHPPowerpoint/IComparable.php';
include '/../vendor/phpppt/Classes/PHPPowerpoint/IOFactory.php';

class PPTools
{
    public static function getPPTFilePath() {
        return dirname(dirname(dirname(dirname(__FILE__)))) . '/web/ppt/';
    }

    public static function getImageFilePath() {
        return dirname(dirname(dirname(dirname(__FILE__)))) . '\web\\';
    }

    public static function setSlide($objPHPPowerPoint, $data) {
        $tools = new PPTools();
        foreach($data as $key=>$value) {
            $currentSlide = $tools->createTemplatedSlide($objPHPPowerPoint);

            $shape = $currentSlide->createDrawingShape();
            $shape->setName('image1');
            $shape->setDescription('the first description image1');
            $shape->setPath(PPTools::getPPTFilePath() . 'images/2.jpg');
            $shape->setWidth(300);
            $shape->setOffsetX(180);
            $shape->setOffsetY(190);

            $shape = $currentSlide->createDrawingShape();
            $shape->setName('image2');
            $shape->setDescription('the first description image2');
            if ($value['community_image1'] != "") {
                $shape->setPath(PPTools::getImageFilePath() . $value['community_image1']);
            } else {
                $shape->setPath(PPTools::getPPTFilePath() . 'images/2.jpg');
            }
            $shape->setWidth(320);
            $shape->setOffsetX(680);
            $shape->setOffsetY(290);

            //创建富文本区
            $shape = $currentSlide->createRichTextShape();
            $shape->setHeight(90);
            $shape->setWidth(300);
            $shape->setOffsetX(200);
            $shape->setOffsetY(490);
            $shape->getAlignment()->setHorizontal(\PHPPowerPoint_Style_Alignment::HORIZONTAL_CENTER);
            $textRun = $shape->createTextRun($value->community_name);
            $textRun->getFont()->setBold(true);
            $textRun->getFont()->setSize(16);
            $textRun->getFont()->setColor(new \PHPPowerPoint_Style_Color('000000'));

            $shape = $currentSlide->createRichTextShape();
            $shape->setHeight(200);
            $shape->setWidth(300);
            $shape->setOffsetX(680);
            $shape->setOffsetY(190);
            $shape->getAlignment()->setHorizontal(\PHPPowerPoint_Style_Alignment::HORIZONTAL_LEFT);
            $textRun = $shape->createTextRun("位置:" . $value->community_position . "\n数量:20\n实际发布:2");
            $textRun->getFont()->setBold(false);
            $textRun->getFont()->setSize(12);
            $textRun->getFont()->setColor(new \PHPPowerPoint_Style_Color('000000'));
        }
    }

    public static function getPPT()
    {
        $objPHPPowerPoint = new \PHPPowerPoint();
        return $objPHPPowerPoint;
    }

    public static function createPPT($module, $data)
    {
        $objPHPPowerPoint = PPTools::getPPT();

        //设置文件属性
        $objPHPPowerPoint->getProperties()->setCreator("Maarten Balliauw");
        $objPHPPowerPoint->getProperties()->setLastModifiedBy("Maarten Balliauw");
        $objPHPPowerPoint->getProperties()->setTitle("Office 2007 PPTX Test Document");
        $objPHPPowerPoint->getProperties()->setSubject("Office 2007 PPTX Test Document");
        $objPHPPowerPoint->getProperties()->setDescription("Test document for Office 2007 PPTX, generated using PHP classes.");
        $objPHPPowerPoint->getProperties()->setKeywords("office 2007 openxml php");
        $objPHPPowerPoint->getProperties()->setCategory("Test result file");

        $objPHPPowerPoint->removeSlideByIndex(0);

        PPTools::setSlide($objPHPPowerPoint, $data);

        $objWriter = \PHPPowerPoint_IOFactory::createWriter($objPHPPowerPoint, 'PowerPoint2007');
        $fileArray = PPTools::getFileName($module);
        $objWriter->save($fileArray['name']);

        return $fileArray['nameorg'];
    }

    public static function getFileName($module) {
        $folder = PPTools::getPPTFilePath();
        $date = date('Y-m-d');
        $fileNameOrg = "/$module$date.pptx";
        $fileName =  $folder.iconv("utf-8","gb2312",$fileNameOrg);
        $fileNameArray = array('name'=>$fileName,'nameorg'=>$fileNameOrg);
        return $fileNameArray;
    }

    /**
     * Creates a templated slide
     *
     * @param \PHPPowerPoint $objPHPPowerPoint
     * @return \PHPPowerPoint_Slide
     */
    function createTemplatedSlide(\PHPPowerPoint $objPHPPowerPoint)
    {
        // Create slide
        $slide = $objPHPPowerPoint->createSlide();

        // Add background image
        $shape = $slide->createDrawingShape();
        $shape->setName('Background');
        $shape->setDescription('Background');
        $shape->setPath(PPTools::getPPTFilePath() . 'images/background.jpg');
        $shape->setWidth(850);
        $shape->setHeight(720);
        $shape->setOffsetX(0);
        $shape->setOffsetY(0);

        // Return slide
        return $slide;
    }
}
?>