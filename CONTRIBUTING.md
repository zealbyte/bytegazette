Building
=========

A quick review of building this theme in development or production ready is
 below. For more detailed instruction, please checkout the
 [official documentation][2].

Build (requires Docker)
---------

The intended build process uses Docker and the Packer Docker image by
 ZealByte with GNU Make. The provided **Makefile** will facilitate the
 provisioning and execution necessary to build this theme.

#### Prerequisites ####

- [Docker][12] to build and run the docker image.
- [GNU Make][15] to execute the make targets in the Makefile.

#### Development Build ####

From the root directory of this theme, execute the following command from the
 terminal. The development build will use the root directory of this repo as the
 theme directory.

```bash
$ make dev
```

#### Production Build ####

From the root directory of this theme, execute the following command from the
 terminal. The production ready theme will be the newly created
 **bytegazette.zip** file located in the root directory of this repo. The files
 included inside the zip file are located in the newly created *build*
 directory.

```bash
$ make build
```

Build (without Docker)
---------

This is the build process performed within Docker containers, when executing
 the *dev* or *build* targets from the **Makefile**.

#### Prerequisites ####

- [PHP 5.3+][15] environment (CLI) to configure the development environment.
- [Node.js][14] environment (CLI) to build the JavaScript front-end bundles.
- [PHP Composer][16] for PHP library dependency management.
- [npm][18] for bundled front-end dependency package management.

#### Packages and Dependencies ####

Install the required PHP dependency packages for development and testing.

```bash
$ composer install
```

Download and install the required dependencies to build the front-end bundles.

```bash
$ npm install
```

#### Development Build ####

Build and watch changes to the source code of the front-end bundles.

```bash
$ npm run watch
```

#### Production Build ####

Build the front-end bundles for production / testing.
```bash
$ npm run build
```

Run Development Build
---------

[Docker Compose][5] with the included *docker-compose.yml* file.

Resources
---------

- [Byte Gazette][2] © 2018 ZealByte - License: GPL 2.0
- [Underscores][10] © 2012-2015 Automattic, Inc. - License: GPL 2.0
- [UIkit 3][11] © 2017-2018 YOOtheme GmbH - License: MIT


[1]: https://zealbyte.org/ "ZealByte"
[2]: https://zealbyte.org/projects/bytegazette "Byte Gazette"
[3]: https://zealbyte.org/projects/packer "ZealByte Web Packer"
[4]: https://bytegazette.com/ "The Byte Gazette"
[10]: https://underscores.me "Underscores"
[11]: https://getuikit.com/ "UIkit 3"
[12]: https://www.docker.com/ "Docker"
[13]: https://docs.docker.com/compose/overview/ "Docker Compose"
[14]: https://nodejs.org/ "Node.js"
[15]: http://www.php.net/ "PHP"
[16]: https://getcomposer.org/ "PHP Composer"
[17]: https://www.gnu.org/software/make/ "GNU Make"

