<?php

/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link          https://cakephp.org CakePHP(tm) Project
 * @package       app.View.Layouts
 * @since         CakePHP(tm) v 0.10.0.1076
 * @license       https://opensource.org/licenses/mit-license.php MIT License
 */

// $cakeDescription = __d('cake_dev', 'CakePHP: the rapid development php framework');
$cakeVersion = __d('cake_dev', 'CakePHP %s', Configure::version())
?>
<!DOCTYPE html>
<html>

<head>
	<?php echo $this->Html->charset(); ?>
	<title>
		<?php echo $this->fetch('title'); ?>
	</title>
	<?php
	echo $this->Html->meta('icon');

	// echo $this->Html->script('https://code.jquery.com/jquery-1.6.2.min.js', array('inline' => false));

	echo $this->Html->css('https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css');
	echo $this->Html->script('https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js', array('inline' => false));
	echo $this->Html->script('https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js', array('inline' => false));

	echo $this->Html->css('cake.generic');

	echo $this->fetch('meta');
	echo $this->fetch('css');
	echo $this->fetch('script');

	?>

	<?php

	echo $this->Html->script('script.js');
	?>

</head>

<body>
	<div id="container">
		<div id="header">
			<div>
				<p>MessageBoard</p>
				<?php 
					if(AuthComponent::user()){
						echo $this->Html->link(AuthComponent::user('name'), array('controller' => 'users', 'action' => 'view', AuthComponent::user('id')));
						echo '<br><br>';
						echo $this->Html->link('Logout', array('controller' => 'users', 'action' => 'logout'));
					} else {
						echo $this->Html->link('Login', array('controller' => 'users', 'action' => 'login'));
					} 
				?>
				&nbsp;
				<?php echo $this->Html->link('Register', array('controller' => 'users', 'action' => 'add')); ?>
				&nbsp;
				<?php echo $this->Html->link('Users', array('controller' => 'users', 'action' => 'index')); ?>
				&nbsp;
				<?php echo $this->Html->link('Conversations', array('controller' => 'conversations', 'action' => 'index')); ?>
			</div>
		</div>
		<div id="content">

			<?php echo $this->Flash->render(); ?>

			<?php echo $this->fetch('content'); ?>
		</div>

	</div>
</body>

</html>