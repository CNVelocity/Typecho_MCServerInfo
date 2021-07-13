<?php
if (!defined('__TYPECHO_ROOT_DIR__')) exit;
/**
 * Show your Minecraft server infomation in the index page
 * 
 * @package MCServerInfo
 * @author CN_Velocity
 * @version 1.0.0
 * @link http://veol.top:8888
 */
class MCServerInfo_Plugin implements Typecho_Plugin_Interface
{
    /**
     * 激活插件方法,如果激活失败,直接抛出异常
     * 
     * @access public
     * @return void
     * @throws Typecho_Plugin_Exception
     */
    public static function activate()
    {
        return '插件启动成功';
    }
    
    /**
     * 禁用插件方法,如果禁用失败,直接抛出异常
     * 
     * @static
     * @access public
     * @return void
     * @throws Typecho_Plugin_Exception
     */
    public static function deactivate(){}
    
    /**
     * 获取插件配置面板
     * 
     * @access public
     * @param Typecho_Widget_Helper_Form $form 配置面板
     * @return void
     */
    public static function config(Typecho_Widget_Helper_Form $form)
    {
        /** 分类名称 */
        $name = new Typecho_Widget_Helper_Form_Element_Text('word', NULL, '输入API地址', _t('MCSM API URL'));
        $form->addInput($name);
    }
    
    /**
     * 个人用户的配置面板
     * 
     * @access public
     * @param Typecho_Widget_Helper_Form $form
     * @return void
     */
    public static function personalConfig(Typecho_Widget_Helper_Form $form){}
    
    /**
     * 插件实现方法
     * 
     * @access public
     * @return void
     */

    public static function render()
    {
        //注入css
        $cssUrl = Helper::options()->pluginUrl . '/MCServerInfo/MCServerInfo.css';
		echo '<link rel="stylesheet" type="text/css" href="' . $cssUrl . '" />' . PHP_EOL;

        //获取当前主题
        $theme = Typecho_Widget::widget('Widget_Options')->theme;

        //获取API地址并解析成数据
        $url = Typecho_Widget::widget('Widget_Options')->plugin('MCServerInfo')->word;
        $ch = curl_init();
        curl_setopt($ch,CURLOPT_URL,$url);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
        $json = curl_exec($ch);
        curl_close($ch);

        //json解码
        $data = json_decode($json, true);

        //显示到侧边栏
        //判断API能否访问
        if ($url != '输入API地址' && $data != NULL):
            $infoShowed = '';

            //判断当前主题
            if ( $theme == 'MWordStar'):
                $infoShowed = '<div class="MWordStar">';
            else:
                $infoShowed = '<div style="overflow:hidden">';
            endif;
            
            //输出服务器ID
            $infoShowed .= '<div class="infoName">'.'Server Name:'.'</div>'.'<div class="serverInfo">'.$data["id"].'</div>'.'<div style="clear:both"></div>';

            //判断服务器是否开启
            if ($data["status"] != 0):
                //开启输出版本，在线玩家
                $infoShowed .= '<div class="infoName">'.'Version:'.'<br>'.'Online Players:'.'</div>'.'<div class="serverInfo">'.$data["version"].'<br>'.$data["current_players"].' / '.$data["max_players"].'</div>';

            //未开启输出提示信息
            else:
                $infoShowed .= '<div class="false">'.'啊！服务器没开！'.'</div>';
            endif;
            $infoShowed .= '</div>';
            echo $infoShowed;
        endif;
    }
}
