{ pkgs }: {
	 channel = "stable-24.05";

	  home.packages = [
		pkgs.sqlite
		pkgs.php80Packages.composer
		pkgs.php82
		pkgs.nodejs
		pkgs.nodePackages.nodemon
		pkgs.gh
		pkgs.sudo

	];
  deps = [
     pkgs.php
   ];
	
	 idx = {
		extensions = [];
		 previews = {
			  web = {
			    command = ["nix-shell --packages pkgs.php82 | /nix/store/6abnc1cqyn1y6f7nh6v76aa6204mc79z-php-with-extensions-8.2.20 -S 0.0.0.0:8000 -t ."];
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
					"nix-shell --packages pkgs.php82 | /nix/store/6abnc1cqyn1y6f7nh6v76aa6204mc79z-php-with-extensions-8.2.20 -S 0.0.0.0:8000 -t ."
				'';
				default.openFiles = [ "index.php" ];
			};
		};
	};
}