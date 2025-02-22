{ pkgs }: {
	deps = [
		pkgs.sqlite
		pkgs.php80Packages.composer
		pkgs.php82
		pkgs.nodejs_23
		pkgs.nodePackages.nodemon
		pkgs.gh
		pkgs.sudo

	];
}