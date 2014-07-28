<?php /* @var $this Controller */ ?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="language" content="en" />

        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl; ?>/css/styles.css" />
        <title><?php echo CHtml::encode($this->pageTitle); ?></title>

        <?php
        Yii::app()->bootstrap->register();
        Yii::app()->bootstrap->registerTooltip();
        ?>
    </head>

    <body>

        <?php
        $this->widget('bootstrap.widgets.TbNavbar', array(
            'items' => array(
                array(
                    'class' => 'bootstrap.widgets.TbMenu',
                    'items' => array(
                        array('label' => 'Home', 'url' => array('/site/index')),
                        array('label' => 'About', 'url' => array('/site/page', 'view' => 'about'), 'visible' => !Yii::app()->user->isAdmin),
                        array('label' => 'Contact', 'url' => array('/site/contact'), 'visible' => !Yii::app()->user->isAdmin),
                        array('label' => 'Register', 'url' => array('/user/register'), 'visible' => Yii::app()->user->isGuest),
                        array('label' => 'Login', 'url' => array('/site/login'), 'visible' => Yii::app()->user->isGuest),
                        array('label' => 'Logout (' . Yii::app()->user->name . ')', 'url' => array('/site/logout'), 'visible' => !Yii::app()->user->isGuest),
                        array('label' => 'Admin', 'url' => array('/admin/index'), 'visible' => Yii::app()->user->isAdmin),
                    ),
                ),
            ),
        ));
        ?>

        <div class="container" id="page">

            <?php if (isset($this->breadcrumbs)): ?>
                <?php
                $this->widget('bootstrap.widgets.TbBreadcrumbs', array(
                    'links' => $this->breadcrumbs,
                ));
                ?><!-- breadcrumbs -->
            <?php endif ?>

            <?php
            $this->widget('bootstrap.widgets.TbAlert', array(
                'block' => true, // display a larger alert block?
                'fade' => true, // use transitions?
                'closeText' => '&times;', // close link text - if set to false, no close link is displayed
                'alerts' => array(// configurations per alert type
                    'success' => array('block' => true, 'fade' => true, 'closeText' => '&times;'), // success, info, warning, error or danger
                     'error' => array('block' => true, 'fade' => true, 'closeText' => '&times;'), // success, info, warning, error or danger
                ),
            ));
            ?>

            <?php if (!Yii::app()->user->isguest) { ?>
                <!--Show Sidebar -->

                <div class="row">
                    <div class="span2">
                        <?php
                        $this->widget('bootstrap.widgets.TbMenu', array(
                            'type' => 'list',
                            'items' => array(
                                array('label' => 'My Learningapp'),
                                array('label' => 'Stacks', 'url' => array('/stack/index'), 'image' => 'stack_16.png'),
                                array('label' => 'Export', 'url' => array('/export/index'), 'image' => 'export_16.png'),
                                array('label' => 'Administration', 'visible' => Yii::app()->user->isAdmin),
                                array('label' => 'User management', 'url' => array('/adminuser/admin'), 'visible' => Yii::app()->user->isAdmin, 'image' => 'users_16.png'),
                                array('label' => 'Public questions', 'url' => array('/adminquestion/admin'), 'visible' => Yii::app()->user->isAdmin, 'image' => 'publicquestion_16.png'),
                                array('label' => 'Categories', 'url' => array('/admincategory/admin'), 'visible' => Yii::app()->user->isAdmin, 'image' => 'categories_16.png'),
                                array('label' => 'Trashmailprovider', 'url' => array('/admintrashMailProvider/admin'), 'visible' => Yii::app()->user->isAdmin, 'image' => 'trashmail_16.png'),
                                array('label' => 'PROFILE'),
                                array('label' => 'Change password', 'url' => array('/user/changePassword'),'image' => 'password_16.png'),
                                array('label' => 'Contact', 'url' => array('/site/contact'),'image' => 'mail_16.png'),
                            ),
                        ));
                        ?>
                    </div>
                    <div class="span10">
                        <?php echo $content; ?> 
                    </div>
                </div>

            <?php } else { ?>
                <!--Show no Sidebar-->
                <?php echo $content; ?>
            <?php } ?>


            <div class="clear"></div>

        </div><!-- page -->

    </body>
</html>
