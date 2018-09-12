<?php
/**
 * BuddyPress - Members Loop
 *
 * @since 3.0.0
 * @version 3.0.0
  King Bee Std 1.0
 */



bp_nouveau_before_loop(); ?>

<?php if ( bp_get_current_member_type() ) : ?>
	<p class="current-member-type"><?php bp_current_member_type_message(); ?></p>
<?php endif; ?>

<?php
$excluded_roles = array ('administrator', 'editor'); ///function de recherche des users à exclures ( sur roles)

if ( bp_has_members(  'exclude=' . exclude_by_role($excluded_roles) . '&' . bp_ajax_querystring( 'members' ) ) ) : ?>

	<?php bp_nouveau_pagination( 'top' ); ?>

	<ul id="members-list" class="<?php bp_nouveau_loop_classes(); ?>">

	<?php while ( bp_members() ) : bp_the_member(); ?>


		<li <?php bp_member_class( array( 'item-entry' ) ); ?> data-bp-item-id="<?php bp_member_user_id(); ?>" data-bp-item-component="members">
			<div class="list-wrap row">

                <div class="col-3 col-md-1">
				<div class="item-avatar">
              
					<a href="<?php bp_member_permalink(); ?>"><?php bp_member_avatar( bp_nouveau_avatar_args() ); ?></a>
				</div>
                </div>

				<div class="item col-9 col-md-11">

					<div class="item-block">

						<h3 class="member-name mt-0 mb-1">
							<a href="<?php bp_member_permalink(); ?>"><?php bp_member_name(); ?></a>
						</h3>

						<?php 
//KBS
                         if(xprofile_get_field_data( 'Organisme', bp_get_member_user_id()  ))                      
                         echo '<div class="organisme"><h5 class="mb-2">'.xprofile_get_field_data( 'Organisme', bp_get_member_user_id()).'</h5></div>';
                        if(xprofile_get_field_data( 'Titre', bp_get_member_user_id()  ))                      
                         echo '<div class=""><p class="mb-0">'.xprofile_get_field_data( 'Titre', bp_get_member_user_id()).'</p></div>';
                         if(xprofile_get_field_data( 'Fonction', bp_get_member_user_id()  ))                      
                         echo '<div class=""><p class="mb-0">'.xprofile_get_field_data( 'Fonction', bp_get_member_user_id()).'</p></div>';

                        
                        if ( bp_nouveau_member_has_meta()  && (current_user_can('administrator') OR current_user_can('editor')) ) : ?>
							<p class="item-meta last-activity">
								<?php bp_nouveau_member_meta(); ?>
							</p><!-- #item-meta -->
						<?php endif; ?>

						<?php
						bp_nouveau_members_loop_buttons(
							array(
								'container'      => 'ul',
								'button_element' => 'button',
							)
						);
?>

					</div>

					<?php if ( bp_get_member_latest_update() && ! bp_nouveau_loop_is_grid() ) : ?>
					<div class="user-update">
						<p class="update"> <?php bp_member_latest_update(); ?></p>
					</div>
						<?php endif; ?>

				</div><!-- // .item -->



			</div>
		</li>

	<?php endwhile; ?>

	</ul>

	<?php bp_nouveau_pagination( 'bottom' ); ?>

<?php
else :

	bp_nouveau_user_feedback( 'members-loop-none' );

endif;
?>

<?php bp_nouveau_after_loop(); ?>
