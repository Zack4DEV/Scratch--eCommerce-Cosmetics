{ pkgs }: {
	 channel = "stable-24.05";


   home.packages = [
			pkgs.nano
			pkgs.gh
			pkgs.sudo
			pkgs.sqlite
			pkgs.php80Packages.composer
			pkgs.nodejs
   ];

	deps = [
		 pkgs.php
	];
	
	 idx = {
		extensions = [];
		 previews = {
			  web = {
			    command = ["php -S 0.0.0.0:8000 -t /home/runner/workspace"];
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
				cd /nix/store/6abnc1cqyn1y6f7nh6v76aa6204mc79z-php-with-extensions-8.2.20 && php -S 0.0.0.0:8000 -t /home/runner/workspace
				'';
				default.openFiles = [ "index.php" ];
			};
		};
	};
}