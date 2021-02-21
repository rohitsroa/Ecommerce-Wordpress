<ul class="ekit-team-social-list">
	<?php foreach ($ekit_team_social_icons as $icon) { ?>
		<li <?php echo $this->get_render_attribute_string('social_item_' . $icon['_id']); ?>>
			<a <?php echo $this->get_render_attribute_string('social_link_' . $icon['_id']); ?>>
				<?php \Elementor\Icons_Manager::render_icon( $icon['ekit_team_icons'], [ 'aria-hidden' => 'true' ] ); ?>
			</a>
		</li>
	<?php } ?>
</ul>
