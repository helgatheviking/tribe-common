<?php

namespace Tribe;

use Tribe__Template as Template;

class TemplateTest extends \Codeception\TestCase\WPTestCase {
	/**
	 * It should allow setting a number of values at the same time
	 *
	 * @test
	 */
	public function should_allow_setting_a_number_of_values_at_the_same_time() {
		$template = new Template();

		$template->set_values( [
			'twenty-three' => '23',
			'eighty-nine'  => 89,
			'an_array'     => [ 'key' => 2389 ],
			'an_object'    => (object) [ 'key' => 89 ],
			'a_null_value' => null,
		] );

		$this->assertEquals( '23', $template->get( 'twenty-three' ) );
		$this->assertEquals( 89, $template->get( 'eighty-nine' ) );
		$this->assertEquals( [ 'key' => 2389 ], $template->get( 'an_array' ) );
		$this->assertEquals( (object) [ 'key' => 89 ], $template->get( 'an_object' ) );
		$this->assertEquals( null, $template->get( 'a_null_value' ) );
	}

	/**
	 * It should allow setting contextual values without overriding the primary values
	 *
	 * @test
	 */
	public function should_allow_setting_contextual_values_without_overriding_the_primary_values() {
		$template      = new Template();
		$global_set    = [
			'twenty-three' => '23',
			'eighty-nine'  => 89,
		];
		$global_values = $global_set;

		$template->set_values( $global_set, false );

		$this->assertEquals( $global_values, $template->get_global_values() );
		$this->assertEquals( [], $template->get_local_values() );
		$this->assertEquals( $global_values, $template->get_values() );

		$local_set = [
			'eighty-nine' => 2389,
			'another_var' => 'another_value',
		];
		$template->set_values( $local_set );

		$this->assertEquals( $global_values, $template->get_global_values() );
		$this->assertEquals( $local_set, $template->get_local_values() );
		$this->assertEquals( array_merge( $global_values, $local_set ), $template->get_values() );
	}
}