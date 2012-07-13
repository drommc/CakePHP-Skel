<?php
/**
 * Top Navigation menu
 *
 * TODO Customize me (Brand name, menus ...)
 */
?>
<div class="navbar navbar-fixed-top">
	<div class="navbar-inner">
		<div class="container">
			<a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</a>
			<?= $this->Html->link(
				'OccitechBakedApp!',
				'/',
				array('class' => 'brand', 'escape' => false)
			); ?>
			<div class="nav-collapse">
				<ul class="nav">
					<li><?= $this->Html->link(__('First link'), '#'); ?></li>
					<li><?= $this->Html->link(__('Second link'), '#'); ?></li>
					<li><?= $this->Html->link(__('Third link'), '#'); ?></li>
				</ul>
				<ul class="nav pull-right">
					<?php if (empty($userData)) : ?>
						<li>
							<?= $this->Html->link(__('Login / Register'), '#') ?>
						</li>
					<?php else : ?>
						<li class="dropdown loggedin">
							<?= $this->Html->dropdownTrigger($userData['email']) ?>
							<ul class="dropdown-menu">
								<li>
									<?= $this->Html->link(
										__('Logout'),
										array('plugin' => null, 'controller' => 'users', 'action' => 'logout', 'admin' => false),
										array('prepend' => 'icon-off')
									) ?>
								</li>
							</ul>
						</li>
					<?php endif; ?>
				</ul>
			</div>
		</div>
	</div>
</div>