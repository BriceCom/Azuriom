<?php

namespace Tests\Unit\Plugins\Hunt;

use PHPUnit\Framework\TestCase;

class DryStructureTest extends TestCase
{
    private const ROOT = __DIR__.'/../../../../';

    public function test_reward_command_helpers_are_centralized_in_form_partial(): void
    {
        $form = file_get_contents(self::ROOT.'plugins/hunt/resources/views/admin/rewards/_form.blade.php');
        $create = file_get_contents(self::ROOT.'plugins/hunt/resources/views/admin/rewards/create.blade.php');
        $edit = file_get_contents(self::ROOT.'plugins/hunt/resources/views/admin/rewards/edit.blade.php');

        $this->assertNotFalse($form);
        $this->assertNotFalse($create);
        $this->assertNotFalse($edit);

        $this->assertStringContainsString('function addCommand()', $form);
        $this->assertStringContainsString('function removeCommand(button)', $form);

        $this->assertStringNotContainsString('function addCommand()', $create);
        $this->assertStringNotContainsString('function removeCommand(button)', $create);

        $this->assertStringNotContainsString('function addCommand()', $edit);
        $this->assertStringNotContainsString('function removeCommand(button)', $edit);
    }

    public function test_settings_page_does_not_render_editable_settings_form(): void
    {
        $settingsView = file_get_contents(self::ROOT.'plugins/hunt/resources/views/admin/settings.blade.php');
        $this->assertNotFalse($settingsView);

        $this->assertStringNotContainsString('<form', $settingsView);
    }
}
