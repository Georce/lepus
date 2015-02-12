<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * DiliCMS
 *
 * 一款基于并面向CodeIgniter开发者的开源轻型后端内容管理系统.
 *
 * @package     DiliCMS
 * @author      DiliCMS Team
 * @copyright   Copyright (c) 2011 - 2012, DiliCMS Team.
 * @license     http://www.dilicms.com/license
 * @link        http://www.dilicms.com
 * @since       Version 1.0
 * @filesource
 */

// ------------------------------------------------------------------------

/**
 * DiliCMS Loader 扩展CI_Loader
 *
 * 用于支持多皮肤
 *
 * @package     DiliCMS
 * @subpackage  core
 * @category    core
 * @author      Jeongee
 * @link        http://www.dilicms.com
 */		
class MY_Loader extends CI_Loader
{
	/**
     * 构造函数
     *
     * @access  public
     * @return  void
     */
	public function __construct()
	{
		parent::__construct();
	}
	
	// ------------------------------------------------------------------------

    /**
     * 切换视图路径
     *
     * @access  public
     * @return  void
     */
	public function switch_theme($theme = 'default')
	{
		$this->_ci_view_paths = array( 'templates/' . $theme . '/'	=> TRUE);
	}
	
	// ------------------------------------------------------------------------

}

/* End of file Dili_Loader.php */
/* Location: ./admin/core/Dili_Loader.php */