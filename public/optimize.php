<?php

	// Establish configurations.
	require("../includes/config.php");

	// Make sure the portfolio id is available as a GET parameter.
	if (empty($_GET["id"]))
	{
		redirect('./');
	}

	// GET the portfolio and tickers at this id for this user.
	$portfolio = CS50::query("SELECT * FROM portfolios WHERE id = ? AND user_id = ?", $_GET["id"], $_SESSION["cs673_id"]);
	$tickers = CS50::query("SELECT * FROM tickers WHERE portfolio_id = ?", $_GET["id"]);

	if($portfolio == null || $tickers == null)
	{
		redirect("./");
	}

	/**
	 *	GET
	 *
	 *	When a user arrives at this page, show two opimized portfolios - ER and Beta.
	 */
	if($_SERVER["REQUEST_METHOD"] == "GET")
	{
		// Generate ER's and Betas.
		$result = get_expected_return_beta($portfolio, $tickers);

		// Store optimized results.
		$optimized = [];
		$output = [];

		/**
		 *
		 *	Minimize Beta by constraining Expected Return.
		 *
		 */
		$result["request"] = [
			"expected_return" => $result["portfolio"]["statistics"]["expected_return"],
			"beta" => null
		];

		exec("python ../storage/scripts/portfolio.py '" . json_encode($result) . "'", $output);
		$output = json_decode($output[ count($output) - 1 ], true);
		$output["request"] = $result["request"];
		array_push($optimized, $output);

		/**
		 *
		 *	Minimize Expected Return by constraining Beta.
		 *
		 */
		 $result["request"] = [
			"expected_return" => null,
			"beta" => $result["portfolio"]["statistics"]["beta"]
		];

		$output = [];

		exec("python ../storage/scripts/portfolio.py '" . json_encode($result) . "'", $output);
		$output = json_decode($output[ count($output) - 1 ], true);
		$output["request"] = $result["request"];
		array_push($optimized, $output);

		$status = array_map(function($element) {
			return abs($element["status"]);
		}, $optimized);

		render("optimize.php", [
			"optimized" => $optimized,
			"portfolio" => $result["portfolio"],
			"tickers" => $result["tickers"],
			"status" => array_sum($status) == 0 ? 0 : -1,
		]);
	}

	header("Content-Type: application/json");
	echo json_encode($result);
	exit;

	/**
	 *
	 *	Combinations: (<constraint>, null), (null, <constraint>), (<constraint>, <constraint>)
	 *
	 */


	echo json_encode($result);
	exit;

	$optimized = [];
	exec("python ../storage/scripts/portfolio.py '" . json_encode($result) . "'", $optimized);

	$optimized = json_decode($optimized[ count($optimized) - 1 ]);
	header("Content-Type: application/json");
	echo json_encode($optimized);

