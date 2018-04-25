<?php
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\Form;
use SilverStripe\Forms\FormAction;
use SilverStripe\Forms\RequiredFields;
use SilverStripe\Forms\TextField;
use SilverStripe\Forms\DropdownField;
use SilverStripe\ORM\ArrayList;

class DesignerPageController extends PageController
{
    private $imageOptions = null;
    private static $PossibleOptions = [
        'ScaleWidth' => [150],
        'ScaleMaxWidth' => [100],
        'ScaleHeight' => [150],
        'ScaleMaxHeight' => [150],
        'Fit' => [300,300],
        'FitMax' => [300,300],
        'ResizedImage' => [200, 300],
        'Fill' => [150,150],
        'FillMax' => [150,150],
        'CropWidth' => [150],
        'CropHeight' => [50],
        'Pad' => [100,100],
        'Pad' => [100, 100, 'CCCCCC'],
    ];

    private static $allowed_actions = [
        'index',
        'Form',
    ];

    public function index() {
        return $this->renderWith(['DesignerPage', 'Page']);
    }

    public function Form() {
        $map = function ($arr) {
            $mappedArr = [];
            foreach ($arr as $val) {
                $mappedArr[$val] = $val;
            }
            return $mappedArr;
        };
        $fields = new FieldList([
            DropdownField::create('ImageFormatOption', 'Image format option', $map(array_keys(self::$PossibleOptions)))
                ->setEmptyString('Select a format')
                ->setDescription('Some formats require extra fields. If they\'re not supplied this will use examples above as defaults.'),
                TextField::create('Param1', 'Parameter 1'),
                TextField::create('Param2', 'Parameter 2'),
                TextField::create('Param3', 'Parameter 3'),
        ]);

        $actions = new FieldList(
            FormAction::create('withOptions')->setTitle('Update images')
        );

        $required = new RequiredFields('ImageFormatOption');

        $form = new Form($this, 'Form', $fields, $actions, $required);

        return $form;
    }

    public function withOptions($data, Form $form) {
        $this->imageOptions = $data;
        return $this->index();
    }

    public function getFormattedImages() {
        if ($this->imageOptions && isset($this->imageOptions['ImageFormatOption']) && isset(self::$PossibleOptions[$this->imageOptions['ImageFormatOption']])) {
            $option = $this->imageOptions['ImageFormatOption'];
            $defaultParams = self::$PossibleOptions[$this->imageOptions['ImageFormatOption']];
            $param1 = isset($this->imageOptions['Param1']) && $this->imageOptions['Param1'] ? $this->imageOptions['Param1'] : (isset($defaultParams[0]) ? $defaultParams[0] : null);
            $param2 = isset($this->imageOptions['Param2']) && $this->imageOptions['Param2'] ? $this->imageOptions['Param2'] : (isset($defaultParams[1]) ? $defaultParams[1] : null);
            $param3 = isset($this->imageOptions['Param3']) && $this->imageOptions['Param3'] ? $this->imageOptions['Param3'] : (isset($defaultParams[2]) ? $defaultParams[2] : null);
            $images = [];
            foreach ($this->DesignFragments() as $image) {
                $images[] = $this->formatImage($image, $option, $defaultParams, $param1, $param2, $param3);
            }
            return new ArrayList($images);
        } else {
            return $this->DesignFragments();
        }
    }

    private function formatImage($image, $option, $defaultParams, $param1, $param2, $param3) {
        if (count($defaultParams) == 1) {
            return $image->$option($param1);
        } else if (count($defaultParams) == 2) {
            return $image->$option($param1, $param2);
        } else if (count($defaultParams) == 3) {
            return $image->$option($param1, $param2, $param3);
        }
    }
}
