<h5 class="cell margin-top-1 acym__campaign__sendsettings__title-settings"><?php echo acym_translation('ACYM_WHEN_EMAIL_WILL_BE_SENT').acym_info('ACYM_PRESELECT_DESC'); ?></h5>
<div class="cell grid-x align-center">
	<div class="cell grid-x medium-11 acym__campaign__sendsettings__send-type grid-margin-x">
        <?php
        if (empty($data['currentCampaign']->send_specific)) {
            if (!empty($data['currentCampaign']->sent) && empty($data['currentCampaign']->active)) { ?>
				<div class="acym__hide__div"></div>
				<h3 class="acym__title__primary__color acym__middle_absolute__text text-center"><?php echo acym_translation('ACYM_CAMPAIGN_ALREADY_QUEUED'); ?></h3>
            <?php } ?>
			<div class="cell grid-x grid-margin-x margin-bottom-1">
				<div class="cell auto grid-x align-center">
                    <?php
                    $class = $data['currentCampaign']->send_now ? '' : 'button-radio-unselected';
                    $class .= $data['currentCampaign']->draft ? '' : ' button-radio-disabled';
                    ?>
					<button type="button" class="cell medium-9 small-12 button-radio acym__campaign__sendsettings__buttons-type <?php echo $class; ?>" id="acym__campaign__sendsettings__now" data-sending-type="<?php echo $data['campaignClass']::SENDING_TYPE_NOW; ?>"><?php echo acym_translation('ACYM_NOW'); ?></button>
				</div>
                <?php
                $tooltip = acym_level(1) ? '' : 'data-acym-tooltip="'.acym_translation_sprintf('ACYM_USE_THIS_FEATURE', 'AcyMailing Essential').'"';
                $class = $data['currentCampaign']->send_scheduled ? '' : 'button-radio-unselected';
                $class .= !acym_level(1) || !$data['currentCampaign']->draft ? ' button-radio-disabled' : '';
                ?>
				<div class="cell auto grid-x align-center">
					<button type="button" <?php echo $tooltip; ?> class="cell medium-9 small-12 button-radio acym__campaign__sendsettings__buttons-type <?php echo $class; ?>" id="acym__campaign__sendsettings__scheduled" data-sending-type="<?php echo $data['campaignClass']::SENDING_TYPE_SCHEDULED; ?>"><?php echo acym_translation('ACYM_SCHEDULED'); ?></button>
				</div>
                <?php
                $tooltip = acym_level(2) ? '' : 'data-acym-tooltip="'.acym_translation_sprintf('ACYM_USE_THIS_FEATURE', 'AcyMailing Enterprise').'"';
                $class = $data['currentCampaign']->send_auto ? '' : 'button-radio-unselected';
                $class .= !acym_level(2) || !$data['currentCampaign']->draft ? ' button-radio-disabled' : '';
                ?>
				<div class="cell auto grid-x align-center">
					<button type="button" <?php echo $tooltip; ?> class="cell medium-9 small-12 button-radio acym__campaign__sendsettings__buttons-type <?php echo $class; ?>" id="acym__campaign__sendsettings__auto" data-sending-type="<?php echo $data['campaignClass']::SENDING_TYPE_AUTO; ?>"><?php echo acym_translation('ACYM_AUTO'); ?></button>
				</div>
			</div>
        <?php } else { ?>
			<div class="cell grid-x margin-bottom-1">
                <?php echo $data['currentCampaign']->send_specific[0]['whenSettings']; ?>
			</div>
        <?php } ?>
	</div>
</div>

<h5 class="cell margin-top-1 margin-bottom-1 acym__campaign__sendsettings__title-settings"><?php echo acym_translation('ACYM_ADDITIONAL_SETTINGS'); ?></h5>
<div class="cell grid-x margin-left-1">
	<div class="cell medium-11 grid-margin-x grid-x acym__campaign__sendsettings__params margin-left-3" data-show="acym__campaign__sendsettings__now" <?php echo $data['currentCampaign']->send_now ? '' : 'style="display: none"'; ?>>
		<p><?php echo acym_translation('ACYM_SENT_AS_SOON_CAMPAIGN_SAVE'); ?></p>
	</div>
	<div class="cell grid-x acym__campaign__sendsettings__params margin-left-3" data-show="acym__campaign__sendsettings__scheduled" <?php echo $data['currentCampaign']->send_scheduled ? '' : 'style="display: none"'; ?>>
		<div class="cell grid-x acym__campaign__sendsettings__display-send-type-scheduled">
			<p id="acym__campaign__sendsettings__scheduled__send-date__label" class="cell shrink"><?php echo acym_translation('ACYM_CAMPAIGN_WILL_BE_SENT'); ?></p>
			<label class="cell shrink" for="acym__campaign__sendsettings__send">
                <?php
                $value = empty($data['currentCampaign']->sending_date) ? '' : acym_date($data['currentCampaign']->sending_date, 'Y-m-d H:i');
                echo acym_tooltip(
                    '<input class="text-center acy_date_picker" data-acym-translate="0" type="text" name="sendingDate" id="acym__campaign__sendsettings__send-type-scheduled__date" value="'.acym_escape($value).'" readonly>',
                    acym_translation('ACYM_CLICK_TO_EDIT')
                );
                ?>
			</label>
		</div>
	</div>
	<div class="cell grid-x align-center margin-left-3">
		<div class="cell grid-x align-center acym__campaign__sendsettings__params" data-show="acym__campaign__sendsettings__auto" <?php echo $data['currentCampaign']->send_auto ? '' : 'style="display: none"'; ?>>
			<div class="cell grid-x acym_vcenter">
				<p class="cell shrink"><?php echo acym_translation('ACYM_THIS_WILL_GENERATE_CAMPAIGN_AUTOMATICALLY'); ?></p>
				<div class="cell shrink grid-x margin-left-1">
					<div class="cell shrink margin-right-1">
                        <?php
                        echo acym_select(
                            $data['triggers_select'],
                            'acym_triggers',
                            empty($data['currentCampaign']->sending_params) ? null : key($data['currentCampaign']->sending_params),
                            'class="acym__select"'
                        );
                        ?>
					</div>
					<div class="cell shrink grid-x grid-margin-x">
                        <?php
                        foreach ($data['triggers_display'] as $key => $display) {
                            echo '<div class="acym__campaign__sendsettings__params__one cell grid-x" data-trigger-show="'.$key.'" style="display: none">';
                            echo str_replace('[triggers][classic]['.$key.']', $key, $display);
                            echo '</div>';
                        }
                        ?>
					</div>
				</div>
			</div>
			<div class="cell grid-x margin-top-1">
                <?php
                echo acym_switch(
                    'need_confirm',
                    isset($data['currentCampaign']->sending_params['need_confirm_to_send']) ? $data['currentCampaign']->sending_params['need_confirm_to_send'] : 1,
                    acym_translation('ACYM_CONFIRM_AUTOCAMPAIGN'),
                    [],
                    'shrink',
                    'shrink'
                );
                ?>
			</div>
		</div>
	</div>
    <?php if (!empty($data['langChoice'])) { ?>
		<div class="cell grid-x margin-top-1 margin-left-3">
			<label class="cell medium-7 large-4">
                <?php
                echo acym_translation('ACYM_EMAIL_LANGUAGE');
                echo acym_info('ACYM_EMAIL_LANGUAGE_DESC');
                ?>
			</label>
			<div class="cell medium-5 large-3">
                <?php echo $data['langChoice']; ?>
			</div>
		</div>
    <?php }
    if (!empty($data['currentCampaign']->send_specific) && !empty($data['currentCampaign']->send_specific[0]['additionnalSettings'])) {
        echo $data['currentCampaign']->send_specific[0]['additionnalSettings'];
    } ?>
	<div class="cell grid-x medium-10 large-7 xlarge-5 margin-left-3">
        <?php
        $label = acym_translation('ACYM_TRACK_THIS_CAMPAIGN');
        $label .= acym_info('ACYM_TRACK_THIS_CAMPAIGN_DESC');
        echo acym_switch(
            'senderInformation[tracking]',
            isset($data['currentCampaign']->tracking) ? $data['currentCampaign']->tracking : 1,
            $label,
            []
        ); ?>
	</div>
</div>
