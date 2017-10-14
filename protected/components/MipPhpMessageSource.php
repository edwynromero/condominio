<?php

class MipPhpMessageSource extends CPhpMessageSource
{
	/**
	 * @var array the message paths for extensions that do not have a base class to use as category prefix.
	 * The format of the array should be:
	 * <pre>
	 * array(
	 *     'ExtensionName' => 'ext.ExtensionName.messages',
	 * )
	 * </pre>
	 * Where the key is the name of the extension and the value is the alias to the path
	 * of the "messages" subdirectory of the extension.
	 * When using Yii::t() to translate an extension message, the category name should be
	 * set as 'ExtensionName.categoryName'.
	 * Defaults to an empty array, meaning no extensions registered.
	 * @since 1.1.13
	 */
	public $extensionBasePaths=array();
		
}