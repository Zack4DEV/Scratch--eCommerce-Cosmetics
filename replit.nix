{ pkgs }: {
	 channel = "stable-24.05";

	 deps = [
		pkgs.sqlite
		pkgs.php80Packages.composer
		pkgs.php82
		pkgs.nodejs
		pkgs.nodePackages.nodemon
		pkgs.gh
		pkgs.sudo

	];
	
	 idx = {
		extensions = [];
		 previews = {
			  web = {
			    command = ["php -S 0.0.0.0:8000 -t ."];
			    manager = "web";
			    env = {
			      PORT = "$PORT";
			    };
			  };
		 };
		workspace = {
			onCreate = {
			};
			onStart = {
				serve = ''
					"php -S 0.0.0.0:8000 -t ."
				'';
				default.openFiles = [ "index.php" ];
			};
		};
	};
}