{ pkgs }: {
	deps = [
		pkgs.sqlite
		pkgs.php80Packages.composer
		pkgs.php82
		pkgs.nodejs
		pkgs.nodePackages.nodemon
		pkgs.gh
		pkgs.sudo

	];
}