<?php 

namespace Tests\Feature;

use App\Models\UserPresence;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

use function Symfony\Component\Clock\now;

class UserPresenceTest extends TestCase {

  use RefreshDatabase;

  public function test_user_presence_can_toggle_online_status()
  {
    $presence = UserPresence::create([
      'user_type' => 'admin',
      'user_id' => 1,
      'is_online' => true,
      'last_seen_at' => now(),
    ]);

    $this->assertTrue($presence->is_online);

    $presence->update(['is_online' => false]);

    $this->assertFalse($presence->fresh()->is_online);
  }
}