<?php
/**
 * User Fixture
 */
class UserFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'key' => 'primary'),
		'name' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 20, 'collate' => 'utf8mb4_general_ci', 'charset' => 'utf8mb4'),
		'age' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false),
		'birthdate' => array('type' => 'date', 'null' => false, 'default' => null),
		'gender' => array('type' => 'enum(\'male\',\'female\')', 'null' => false, 'default' => null, 'collate' => 'utf8mb4_general_ci', 'charset' => 'utf8mb4'),
		'hobby' => array('type' => 'text', 'null' => false, 'default' => null, 'collate' => 'utf8mb4_general_ci', 'charset' => 'utf8mb4'),
		'profile_picture' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 40, 'collate' => 'utf8mb4_general_ci', 'charset' => 'utf8mb4'),
		'email' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 150, 'collate' => 'utf8mb4_general_ci', 'charset' => 'utf8mb4'),
		'password' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 100, 'collate' => 'utf8mb4_general_ci', 'charset' => 'utf8mb4'),
		'created' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'created_ip' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 200, 'collate' => 'utf8mb4_general_ci', 'charset' => 'utf8mb4'),
		'modified_ip' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 200, 'collate' => 'utf8mb4_general_ci', 'charset' => 'utf8mb4'),
		'last_login' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'utf8mb4', 'collate' => 'utf8mb4_general_ci', 'engine' => 'InnoDB')
	);

/**
 * Records
 *
 * @var array
 */
	public $records = array(
		array(
			'id' => 1,
			'name' => 'Lorem ipsum dolor ',
			'age' => 1,
			'birthdate' => '2024-04-03',
			'gender' => '',
			'hobby' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
			'profile_picture' => 'Lorem ipsum dolor sit amet',
			'email' => 'Lorem ipsum dolor sit amet',
			'password' => 'Lorem ipsum dolor sit amet',
			'created' => '2024-04-03 05:42:50',
			'modified' => '2024-04-03 05:42:50',
			'created_ip' => 'Lorem ipsum dolor sit amet',
			'modified_ip' => 'Lorem ipsum dolor sit amet',
			'last_login' => '2024-04-03 05:42:50'
		),
	);

}
