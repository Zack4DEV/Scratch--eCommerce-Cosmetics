{ pkgs }: {
	 channel = "stable-24.05";


   home.packages = [
			 pkgs.nano
			 pkgs.gh
			 pkgs.sudo
   ];

	deps = [
		 pkgs.php82
		 pkgs.sqlite
		 pkgs.php80Packages.composer
		 pkgs.nodejs
	];
	
	 idx = {
		extensions = [];
		 previews = {
			  web = {
			    command = ["php -S 0.0.0.0:8000 -t ~/Workspace"];
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
					php -S 0.0.0.0:8000 -t ~/Workspace
				'';
				default.openFiles = [ "index.php" ];
			};
		};
	};
}