<?php
	define('PREPEND_PATH', '../');
	$hooks_dir = dirname(__FILE__);
	include("{$hooks_dir}/../defaultLang.php");
	include("{$hooks_dir}/../language.php");
	include("{$hooks_dir}/../lib.php");
	
	/* check access */
	$mi = getMemberInfo();
	if($mi['group'] !== 'Admins') {
		include_once("{$hooks_dir}/../header.php");
		echo error_message("Access denied");
		include_once("{$hooks_dir}/../footer.php");
		exit;
	}

	@set_time_limit(0);
	@ignore_user_abort(true);

	$t0 = time();
	$clients = rand_clients(rand(30, 60));
	$items = rand_items(500);
	$item_prices = rand_item_prices($items);
	$invoices = rand_invoices($clients);
	$invoice_items = rand_invoice_items($invoices, $items);

	$tables = [
		'items' => $items,
		'clients' => $clients,
		'item_prices' => $item_prices,
		'invoices' => $invoices,
		'invoice_items' => $invoice_items,
	];

	$eo = ['silentErrors' => true];
	$out = [];
	foreach ($tables as $tn => $records) {
		sql("TRUNCATE `{$tn}`", $eo);
		sql(mass_insert($tn, $records), $eo);
		$out[] = "{$tn}: " . sqlValue("SELECT COUNT(1) FROM `{$tn}`") . " records created.";
	}

	$tt = time() - $t0;
	$out[] = "Total time: {$tt} seconds.";

	include_once("{$hooks_dir}/../header.php");
	echo implode('<br>', $out);
	include_once("{$hooks_dir}/../footer.php");

	function mass_insert($tn, $recs) {
		if(!count($recs)) return;

		$data = [];
		$fields = '`' . implode('`, `', array_keys($recs[0])) . '`';
		foreach ($recs as $rec) {
			$safe_rec = array_map('makeSafe', $rec);
			$data[] = "('" . implode("', '", $safe_rec) . "')";
		}
		$data = implode(",\n", $data);

		return "INSERT INTO `{$tn}`\n({$fields})\nVALUES\n{$data}";
	}

	function rand_invoices($clients) {
		$num_clients = count($clients);
		$username = getLoggedAdmin();
		$dt_format = app_datetime_format('php', 'dt');
		$invoices = [];

		$i = 0;
		while($i++ < $num_clients * 20) {
			$id = ceil($i / 20);
			if(rand(0, 1)) continue; /* randomize # of invoices per client */

			$ts = time() - 86400 * rand(10, 30) - 50 * (20 - ($i - 1) % 20) * 86400;
			$invoices[] = [
				'code' => date('Ymd', $ts) . sprintf('%03d%03d', $id, $i % 20),
				'status' => any(['Unpaid', 'Paid', 'Paid', 'Paid', 'Paid', 'Paid', 'Paid', 'Cancelled']),
				'date_due' => date('Y-m-d', $ts),
				'client' => $id,
				'client_contact' => $id,
				'client_address' => $id,
				'client_phone' => $id,
				'client_email' => $id,
				'client_website' => $id,
				'client_comments' => $id,
				'discount' => any([0, 0, 0, 0, 0, 0, 0, 2, 3, 4, 5]),
				'tax' => any([0, 5, 9, 10, 13]),
				'created' => date($dt_format, $ts) . " {$username}",
			];
		}

		return $invoices;
	}

	function rand_invoice_items($invoices, $products) {
		$num_invoices = count($invoices);
		$num_products = count($products);
		$items = [];

		$i = 0;
		while($i++ < $num_invoices * 10) {
			$id = ceil($i / 10);
			if(!rand(0, 2)) continue; /* randomize # of items per invoice */

			$items[] = [
				'invoice' => $id,
				'item' => rand(1, $num_products),
				'unit_price' => rand(1000, 3000) / 100,
				'qty' => rand(1, 20),
			];
		}

		return $items;
	}

	function rand_item_prices($items) {
		$num_items = count($items);
		$prices = [];

		$i = 1;
		while($i < $num_items * 5) {
			$id = ceil($i / 5);
			$prices[] = [
				'item' => $id,
				'price' => rand(1000, 3000) / 100,
				'date' => date('Y-m-d', time() - 86400 * rand(10, 30) - 50 * (5 - ($i - 1) % 5) * 86400),
			];
			$i++;
		}

		return $prices;
	}

	function rand_items($num = 0) {
		if($num > 0) {
			$items = [];
			for($i = 0; $i < $num; $i++)
				$items[] = rand_items();
			return $items;
		}

		return [
			'item_description' => rand_name(0).rand_name(0)
		];
	}

	function rand_clients($num = 0) {
		if($num > 0) {
			$clients = [];
			for($i = 0; $i < $num; $i++)
				$clients[] = rand_clients();
			return $clients;
		}

		$contact = rand_name();
		list($city, $country) = rand_city();

		return [
			'name' => rand_name(rand(0, 1)) . any([' LLC.', ' Co.', ' LTD.', ' & Sons.', ' GMBH']),
			'contact' => $contact,
			'title' => any(['CEO', 'CPO', 'CTO', 'VP Sales', 'VP Purchases', 'Regional Sales Manager']),
			'address' => '',
			'city' => $city,
			'country' => $country,
			'phone' => rand(10000000, 999999999),
			'email' => strtolower(implode('.', explode(' ', $contact))) . '@' . any(['hotmail.com', 'yahoo.com', 'gmail.com']),
			'website' => '',
			'comments' => ''
		];
	}

	function any($arr) {

		return $arr[rand(0, count($arr) - 1)];
	}

	function rand_city() {

		return explode(', ', any(['les Escaldes, Andorra', 'Zaranj, Afghanistan', 'Mehtar Lām, Afghanistan', 'Ghormach, Afghanistan', 'Andkhōy, Afghanistan', 'Lushnjë, Albania', 'Yerevan, Armenia', 'Uíge, Angola', 'Lobito, Angola', 'Tandil, Argentina', 'Puerto Iguazú, Argentina', 'Luján, Argentina', 'Dolores, Argentina', 'Villa Regina, Argentina', 'Unquillo, Argentina', 'San Rafael, Argentina', 'Rufino, Argentina', 'Pergamino, Argentina', 'La Rioja, Argentina', 'Famaillá, Argentina', 'Comodoro Rivadavia, Argentina', 'Cañada de Gómez, Argentina', 'San Carlos de Bariloche, Argentina', 'Sankt Pölten, Austria', 'Graz, Austria', 'Morphett Vale, Australia', 'Woodridge, Australia', 'Sydney, Australia', 'Reservoir, Australia', 'Mulgrave, Australia', 'Maitland, Australia', 'Hampton Park, Australia', 'Epping, Australia', 'Craigieburn, Australia', 'Caboolture, Australia', 'Ballarat, Australia', 'Carindale, Australia', 'Clayton, Australia', 'Altona Meadows, Australia', 'Fizuli, Azerbaijan', 'Qaraçuxur, Azerbaijan', 'Kyurdarmir, Azerbaijan', 'Agdzhabedy, Azerbaijan', 'Cazin, Bosnia and Herzegovina', 'Shibganj, Bangladesh', 'Nāgarpur, Bangladesh', 'Jhingergācha, Bangladesh', 'Bhātpāra Abhaynagar, Bangladesh', 'Pār Naogaon, Bangladesh', 'Bhola, Bangladesh', 'Azimpur, Bangladesh', 'Westerlo, Belgium', 'Tielt, Belgium', 'Seraing, Belgium', 'Pont-à-Celles, Belgium', 'Morlanwelz-Mariemont, Belgium', 'Lommel, Belgium', 'Koksijde, Belgium', 'Herentals, Belgium', 'Frameries, Belgium', 'Destelbergen, Belgium', 'Braine-l\'Alleud, Belgium', 'Antwerpen, Belgium', 'Nouna, Burkina Faso', 'Diapaga, Burkina Faso', 'Troyan, Bulgaria', 'Razgrad, Bulgaria', 'Kardzhali, Bulgaria', 'Berkovitsa, Bulgaria', 'Gitega, Burundi', 'Nikki, Benin', 'Banikoara, Benin', 'Villamontes, Bolivia', 'Llallagua, Bolivia', 'Viçosa, Brazil', 'Timon, Brazil', 'Serra Talhada, Brazil', 'São Félix do Xingu, Brazil', 'Salgueiro, Brazil', 'Piracuruca, Brazil', 'Parnamirim, Brazil', 'Ábidos, Brazil', 'Matriz de Camaragibe, Brazil', 'Lago da Pedra, Brazil', 'Itapagé, Brazil', 'Guaraciaba do Norte, Brazil', 'Estreito, Brazil', 'Conceição do Araguaia, Brazil', 'Carolina, Brazil', 'Cabo, Brazil', 'Beberibe, Brazil', 'Araripina, Brazil', 'Água Preta, Brazil', 'Viradouro, Brazil', 'Várzea Grande, Brazil', 'Umuarama, Brazil', 'Três Passos, Brazil', 'Teresópolis, Brazil', 'Taiobeiras, Brazil', 'Serrana, Brazil']));
	}

	function rand_name($gender = null /* 0 = male, 1 = female, null = first last */) {
		$names = [
			/* male names */
			['James', 'John', 'Robert', 'Michael', 'William', 'David', 'Richard', 'Joseph', 'Thomas', 'Charles', 'Christopher', 'Daniel', 'Matthew', 'Anthony', 'Donald', 'Mark', 'Paul', 'Steven', 'Andrew', 'Kenneth', 'Joshua', 'George', 'Kevin', 'Brian', 'Edward', 'Ronald', 'Timothy', 'Jason', 'Jeffrey', 'Ryan', 'Jacob', 'Gary', 'Nicholas', 'Eric', 'Stephen', 'Jonathan', 'Larry', 'Justin', 'Scott', 'Brandon', 'Frank', 'Benjamin', 'Gregory', 'Samuel', 'Raymond', 'Patrick', 'Alexander', 'Jack', 'Dennis', 'Jerry', 'Tyler', 'Aaron', 'Jose', 'Henry', 'Douglas', 'Adam', 'Peter', 'Nathan', 'Zachary', 'Walter', 'Kyle', 'Harold', 'Carl', 'Jeremy', 'Keith', 'Roger', 'Gerald', 'Ethan', 'Arthur', 'Terry', 'Christian', 'Sean', 'Lawrence', 'Austin', 'Joe', 'Noah', 'Jesse', 'Albert', 'Bryan', 'Billy', 'Bruce', 'Willie', 'Jordan', 'Dylan', 'Alan', 'Ralph', 'Gabriel', 'Roy', 'Juan', 'Wayne', 'Eugene', 'Logan', 'Randy', 'Louis', 'Russell', 'Vincent', 'Philip', 'Bobby', 'Johnny', 'Bradley'],
			/* female names */
			['Mary', 'Patricia', 'Jennifer', 'Linda', 'Elizabeth', 'Barbara', 'Susan', 'Jessica', 'Sarah', 'Karen', 'Nancy', 'Margaret', 'Lisa', 'Betty', 'Dorothy', 'Sandra', 'Ashley', 'Kimberly', 'Donna', 'Emily', 'Michelle', 'Carol', 'Amanda', 'Melissa', 'Deborah', 'Stephanie', 'Rebecca', 'Laura', 'Sharon', 'Cynthia', 'Kathleen', 'Helen', 'Amy', 'Shirley', 'Angela', 'Anna', 'Brenda', 'Pamela', 'Nicole', 'Ruth', 'Katherine', 'Samantha', 'Christine', 'Emma', 'Catherine', 'Debra', 'Virginia', 'Rachel', 'Carolyn', 'Janet', 'Maria', 'Heather', 'Diane', 'Julie', 'Joyce', 'Victoria', 'Kelly', 'Christina', 'Joan', 'Evelyn', 'Lauren', 'Judith', 'Olivia', 'Frances', 'Martha', 'Cheryl', 'Megan', 'Andrea', 'Hannah', 'Jacqueline', 'Ann', 'Jean', 'Alice', 'Kathryn', 'Gloria', 'Teresa', 'Doris', 'Sara', 'Janice', 'Julia', 'Marie', 'Madison', 'Grace', 'Judy', 'Theresa', 'Beverly', 'Denise', 'Marilyn', 'Amber', 'Danielle', 'Abigail', 'Brittany', 'Rose', 'Diana', 'Natalie', 'Sophia', 'Alexis', 'Lori', 'Kayla', 'Jane']
		];

		if($gender === null) return rand_name(rand(0, 1)) . ' ' . rand_name(0);
		return any($names[$gender]);
	}