<?php

/**
 * Doctrine Models generator
 *
 * @author Juozas Kaziukenas (juozas@juokaz.com)
 */
class Doctrine_Task_GenerateModels extends Doctrine_Task_GenerateModelsDb
{
    public $description          =   'Generates models compatible with zend framework',
           $optionalArguments    =   array(
           		'connection'       => 'Optionally specify a single connection to generate the models for.',
				'phpDocPackage'    => 'Optionaly specify package name',
				'phpDocSubpackage' => 'Optionali specify sub package name',
				'phpDocName'       => 'Optionaly specify author name',
				'phpDocEmail'      => 'Optionaly specify author email',
           );
    
    public function execute()
    {
    	$models = $this->getArgument('models_path');

        $options = array(
            'pearStyle' => true,
            'generateTableClasses' => true,
            'classPrefix' => 'Model_',
            'baseClassPrefix' => 'Base_',
            'baseClassesDirectory' => null,
            'classPrefixFiles' => false,
            'generateAccessors' => false,
        );
        
        $options += $this->getArguments();
	
        $import = new Doctrine_Import(Doctrine_Manager::connection());
        $import->importSchema($models, (array) $this->getArgument('connection'), $options);

        $this->notify('Generated models successfully from databases');
    }
}