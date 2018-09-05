<?php
/**
 * BuddyPress - Groups Loop
 *
 * @since 3.0.0
 * @version 3.1.0
 */

bp_nouveau_before_loop(); ?>

<?php if ( bp_get_current_group_directory_type() ) : ?>
	<p class="current-group-type"><?php bp_current_group_directory_type_message(); ?></p>
<?php endif; ?>

<?php if ( bp_has_groups( bp_ajax_querystring( 'groups' ) ) ) : ?>

	<?php bp_nouveau_pagination( 'top' ); ?>

	<ul id="groups-list" class="<?php bp_nouveau_loop_classes(); ?>">

	<?php
	while ( bp_groups() ) :
		bp_the_group();
        $group_id=bp_get_group_id();
	?>

		<li <?php bp_group_class( array( 'item-entry' ) ); ?> data-bp-item-id="<?php bp_group_id(); ?>" data-bp-item-component="groups">
			<div class="list-wrap row">

				<?php if ( ! bp_disable_group_avatar_uploads() ) : ?>
					<div class="col-2 col-md-3">
						<a href="<?php bp_group_permalink(); ?>"><?php bp_group_avatar( bp_nouveau_avatar_args() ); ?></a>
					</div>
				<?php endif; ?>

				<div class="item col-10 col-md-9">

					<div class="item-block row">
                        <div class="col-12">
						<h2 class="list-title groups-title"><?php bp_group_link(); ?></h2>
                        </div>
                         <div class="col-12">
                         <?php 
                        echo  groups_get_groupmeta( $group_id, '_ville' ).'. '.groups_get_groupmeta( $group_id, '_cp' ); ?>
                        </div>
                         <div class="col-12">
						<?php if ( bp_nouveau_group_has_meta() ) : ?>

							<p class="item-meta group-details"><?php bp_nouveau_group_meta(); ?></p>

						<?php endif; ?>
                        </div>
                        <?php if(is_user_logged_in()) : ?>
                         <div class="col-12">
						<p class="last-activity item-meta">
							<?php
							printf(
								/* translators: %s = last activity timestamp (e.g. "active 1 hour ago") */
								__( 'active %s', 'buddypress' ),
								bp_get_group_last_active()
							);
							?>
						</p>
                        </div>
                        <?php endif ;?>
					</div>

					<div class="group-desc"><p><?php bp_nouveau_group_description_excerpt('',200);//group: null = actuel ; limit ?></p></div>

					<?php bp_nouveau_groups_loop_item(); ?>

					<?php bp_nouveau_groups_loop_buttons(); ?>

				</div>


			</div>
		</li>

	<?php endwhile; ?>

	</ul>

	<?php bp_nouveau_pagination( 'bottom' ); ?>

<?php else : ?>

	<?php bp_nouveau_user_feedback( 'groups-loop-none' ); ?>

<?php endif; ?>

<?php
bp_nouveau_after_loop();


