<?php defined('SYSPATH') or die('No direct script access.');

abstract class Controller_BaseTemplate extends Controller_Template
{
    public $template = 'template';
    protected $session;
    protected $pre_session;
    protected $curr_user;
    protected $curr_role;

    public function before()
    {
        parent::before();

        $this->session = Session::instance();
        $config = Kohana::$config->load('csr');
        $curr_config = $config->get(Kohana::$environment);
        $controller = $this->request->controller();
        $action = $this->request->action();

        $this->pre_session = $curr_config['pre_session'];
        $this->curr_user = $this->session->get($this->pre_session.'user', null);
        $this->curr_role = $this->session->get($this->pre_session.'role', null);

        $curr_top_nav = $curr_left_nav = '';
        $this->template = View::factory('template')
            ->set('page_title', 'CSR Master V4')
            ->set('curr_top_nav', $curr_top_nav)
            ->set('curr_left_nav', $curr_left_nav)
            ->set('role', $this->curr_role)
            ->set('user', $this->curr_user);

        $controller_access_by_everyone = array('User', 'Welcome');
        if (!in_array($controller, $controller_access_by_everyone))
        {
            if (!$this->curr_user)
            {
                $this->redirect('User/Login');
            }
        }

        if ($this->auto_render)
        {
            // Initialize empty values
            $this->template->title = '';
            $this->template->content = '';
            $this->template->styles = array();
            $this->template->scripts = array();
        }
    }

    public function after()
    {
        if ($this->auto_render)
        {
            $styles = array(
                '/static/global/bootstrap-3.1.1/css/bootstrap.min.css' => 'screen',

                //note select2
                '/static/global/select2/select2.css' => 'screen',
                '/static/global/select2/select2-bootstrap.css' => 'screen',

                //note Zeina
                '/static/global/Zeina/css/font-awesome-ie7.min.css'     => 'screen',
                '/static/global/Zeina/css/font-awesome.min.css'         => 'screen',
                '/static/global/Zeina/css/revolution_settings.css'      => 'screen',
                '/static/global/Zeina/css/eislider.css'                 => 'screen',
                '/static/global/Zeina/css/tipsy.css'                    => 'screen',
                '/static/global/Zeina/css/prettyPhoto.css'              => 'screen',
                '/static/global/Zeina/css/isotop_animation.css'         => 'screen',
                '/static/global/Zeina/css/animate.css'                  => 'screen',
                '/static/global/Zeina/css/flexslider.css'               => 'screen',
                '/static/global/Zeina/css/responsive.css'               => 'screen',
                '/static/global/Zeina/css/style.css'                    => 'screen',
                /*
                '/static/global/Zeina/css/skins/light-blue.css'         => 'screen',
                '/static/global/Zeina/css/bootstrap.min.css'            => 'screen',
                 */

                '/static/project/css/csr.css'                           => 'screen',
            );
            $scripts = array(
                '/static/global/jquery/jquery-1.11.1.min.js',
                '/static/global/jqueryui/js/jquery-ui-1.10.4.custom.min.js',
                '/static/global/underscore/underscore-min.js',
                '/static/global/bootstrap-3.1.1/js/bootstrap.min.js',

                //note Zeina
                '/static/global/Zeina/js/activeaxon_menu.js',
                '/static/global/Zeina/js/animationEnigne.js',
                /*
                '/static/global/Zeina/js/bootstrap.js',
                '/static/global/Zeina/js/bootstrap.min.js',
                 */
                '/static/global/Zeina/js/easypiecharts.js',
                '/static/global/Zeina/js/ie-fixes.js',
                '/static/global/Zeina/js/jquery.base64.js',
                '/static/global/Zeina/js/jquery.carouFredSel-6.2.1-packed.js',
                '/static/global/Zeina/js/jquery.cycle.js',
                '/static/global/Zeina/js/jquery.cycle2.carousel.js',
                '/static/global/Zeina/js/jquery.easing.1.3.js',
                '/static/global/Zeina/js/jquery.easytabs.js',
                '/static/global/Zeina/js/jquery.eislideshow.js',
                '/static/global/Zeina/js/jquery.flexslider.js',
                '/static/global/Zeina/js/jquery.infinitescroll.js',
                '/static/global/Zeina/js/jquery.isotope.js',
                '/static/global/Zeina/js/jquery.parallax-1.1.3.js',
                '/static/global/Zeina/js/jquery.prettyPhoto.js',
                '/static/global/Zeina/js/jQuery.scrollPoint.js',
                '/static/global/Zeina/js/jquery.themepunch.plugins.min.js',
                '/static/global/Zeina/js/jquery.themepunch.revolution.js',
                '/static/global/Zeina/js/jquery.tipsy.js',
                '/static/global/Zeina/js/jquery.validate.js',
                '/static/global/Zeina/js/jQuery.XDomainRequest.js',
                '/static/global/Zeina/js/retina.js',
                '/static/global/Zeina/js/timeago.js',
                '/static/global/Zeina/js/tweetable.jquery.js',
                '/static/global/Zeina/js/zeina.js',

                //note select2
                '/static/global/select2/select2.min.js',

                '/static/project/js/csr.js',
                '/static/project/js/format.js',
                '/static/project/js/url.js',
                '/static/project/js/leftmenu.js',
            );
            $this->template->styles = array_merge($this->template->styles, $styles);
            $this->template->scripts = array_merge($this->template->scripts, $scripts);
        }
        parent::after();
    }

}
