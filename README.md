# Muttnick-dev
version 1.2.9-alpha

Muttnick alpha git project. 

Muttnick is a Web platform for websites built on Slim Framework purposed to
be a lightweight, fast, and secure alternative to other PHP platforms.

[![Documentation Status](https://readthedocs.org/projects/muttnick-dev/badge/?version=latest)](http://muttnick-dev.readthedocs.io/en/latest/?badge=latest) 

## Installation

### With Docker
1. Clone the git repoisitory
2. In the root directory of the repository, run `docker-compose up`
3. Access the site from `http://localhost:8080` and go through the site setup there

### Without docker

1. Install NGINX, PHP7-FPM, and MySQL
2. Clone the git repo within your root www directory
3. Replace the default NGINX site config `default` with the file `default.nginx` found within the repo
3. Restart NGINX
4. Create a MySQL user and database for this site
5. Visit the site at `http://localhost` and follow the site setup there

Software (c) 2017 Jetpack Game Studios
