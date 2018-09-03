module.exports = function( grunt ) {
    "use strict";

    //~~ Инициализация сборщика
    grunt.initConfig( {
        pkg: grunt.file.readJSON( "package.json" ),
            //~~ проверка JS на ошибки
        jshint: {
            options: {
                globals: {
                    jQuery: true
                },
                "esversion": 6,
            },
            grunt_file: {
                src: [ "Gruntfile.js" ]
            },
            lib: {
                src: [ "themes/src/**/*.js" ]
            },
            admin: {
                src: [ "themes/admin/src/js/**/*.js" ]
            },
            ri: {
                src: [ "themes/rusimperia/src/js/**/*.js" ]
            },
        },
            //~~ минификация JS
        uglify: {
            cc_lib: {
                files: {
                    "build/all_lib_concat_compress.min.js": [
                        "themes/src/js/jquery-3.3.1.js",
                        "themes/src/js/cropper.js",
                        "themes/src/js/chosen.jquery.js",
                        "themes/src/js/jquery.colorbox.js",
                        "themes/src/js/jquery.colorbox-ru.js",
                        "themes/src/js/jquery.wysibb.js"
                    ]
                },
                options: {
                    preserveComments: false,
                    report: "min",
                    beautify: {
                        "ascii_only": true
                    },
                    banner: "/*! rusimperia lib concat */",
                    compress: {
                        "hoist_funs": false,
                        loops: false,
                        unused: false
                    }
                }
            },
            min_lib: {
                files: {
                    "public/assets/js/all_lib.min.js": [ "build/all_lib_concat_compress.min.js" ]
                },
                options: {
                    preserveComments: false,
                    report: "min",
                    banner: "/*! rusimperia lib-js */"
                }
            },
            ri_dev: {
                files: {
                    "public/assets/js/site.min.js": [ "themes/rusimperia/src/js/**/*.js" ]
                },
                options: {
                    mangle: false,
                    preserveComments: false,
                    sourceMap: {
                        includeSources: true
                    },
                    sourceMapName: "public/assets/js/site.min.map",
                    report: "min",
                    banner: "/*! rusimperia main-js */"
                }
            },
            ri_prod: {
                files: {
                    "public/assets/js/site.min.js": [ "themes/rusimperia/src/js/**/*.js" ]
                },
                options: {
                    mangle: false,
                    preserveComments: false,
                    report: "min",
                    banner: "/*! rusimperia main-js */"
                }
            },
            admin: {
                files: {
                    "public/assets/js/admin.min.js": [ "themes/admin/src/js/**/*.js" ]
                },
                options: {
                    mangle: false,
                    preserveComments: false,
                    sourceMap: {
                        includeSources: true
                    },
                    sourceMapName: "public/assets/js/admin.min.map",
                    report: "min",
                    banner: "/*! rusimperia admin-js */"
                }
            }
        },
            //~~ объединяем CSS файйлы
        concat: {
            common: {
                src: ['themes/src/css/bootstrap-reboot.css',
                    'themes/src/css/fontawesome.css',
                    'themes/src/css/colorbox.css',
                    'themes/src/css/cropper.css',
                    'themes/src/css/chosen.css',
                    'themes/src/css/wbbtheme.css'],
                dest: 'build/concat_common.css'
            },
            ri: {
                src: ['themes/rusimperia/src/css/**/*.css'],
                dest: 'build/concat_ri.css'
            },
            ri_auth: {
                src: ['themes/src/css/bootstrap-reboot.css', 'themes/rusimperia/src/auth.css'],
                dest: 'build/concat_ri_auth.css'
            },
            admin: {
                src: ['themes/admin/src/css/**/*.css'],
                dest: 'build/concat_admin.css'
            }
        },
            //~~ расставляем вендорные префиксы на основе базы Can I Use
            //~~ npm update caniuse-db - обновление базы
        autoprefixer: {
            options: {
                browsers: ['last 5 versions']
            },
            common: {
                src: 'build/concat_common.css',
                dest: 'build/ap_common.css'
            },
            ri: {
                src: 'build/concat_ri.css',
                dest: 'build/ap_ri.css'
            },
            ri_auth: {
                src: 'build/concat_ri_auth.css',
                dest: 'build/ap_ri_auth.css'
            },
            admin: {
                src: 'build/concat_admin.css',
                dest: 'build/ap_admin.css'
            }
        },
            //~~ минимизируем CSS
        cssmin: {
            options: {
                banner: "/*! rusimperia css */"
            },
            common: {
                files: {
                    'public/assets/css/common.min.css': ['build/ap_common.css']
                }
            },
            ri: {
                files: {
                    'public/assets/css/site.min.css': ['build/ap_ri.css']
                }
            },
            ri_auth: {
                files: {
                    'public/assets/css/auth.min.css': ['build/ap_ri_auth.css']
                }
            },
            admin: {
                files: {
                    'public/assets/css/admin.min.css': ['build/ap_admin.css']
                }
            }
        },
            //~~ задача для постоянного слежения за изменением файлов
        watch: {
            js_ri: {
                files: 'themes/rusimperia/src/js/**/*.js',
                tasks: ['jshint:ri', 'uglify:ri_dev']
            },
            css_ri: {
                files: 'themes/rusimperia/src/css/**/*.css',
                tasks: ['concat:ri', 'autoprefixer:ri', 'cssmin:ri']
            },
            css_ri_auth: {
                files: 'themes/rusimperia/src/auth.css',
                tasks: ['concat:ri_auth', 'autoprefixer:ri_auth', 'cssmin:ri_auth']
            },
            js_admin: {
                files: 'themes/admin/src/js/**/*.js',
                tasks: ['jshint:admin', 'uglify:admin']
            },
            css_admin: {
                files: 'themes/admin/src/css/**/*.css',
                tasks: ['concat:admin', 'autoprefixer:admin', 'cssmin:admin']
            },
            css_common: {
                files: 'themes/src/css/**/*.css',
                tasks: ['concat:common', 'autoprefixer:common', 'cssmin:common']
            }
        },
        // генератор фавиконок
        realFavicon: {
            favicons: {
                src: './themes/rusimperia/src/img/logo.png', //путь до оринигольного логотипа
                dest: './public/assets/icon/', // куда копировать иконки и файлы
                options: {
                    iconsPath: '/assets/icon/', //путь который указывается в метатегах
                    html: [ './themes/rusimperia/views/_partials/icons.php' ], //файлы куда добавить метатеги
                    design: {
                        ios: {
                            pictureAspect: 'backgroundAndMargin',
                            backgroundColor: '#ffffff',
                            margin: '11%',
                            assets: {
                                ios6AndPriorIcons: false,
                                ios7AndLaterIcons: false,
                                precomposedIcons: false,
                                declareOnlyDefaultIcon: true
                            },
                            appName: 'Rus Imperia'
                        },
                        desktopBrowser: {},
                        windows: {
                            pictureAspect: 'noChange',
                            backgroundColor: '#e8e8dd',
                            onConflict: 'override',
                            assets: {
                                windows80Ie10Tile: true,
                                windows10Ie11EdgeTiles: {
                                    small: true,
                                    medium: true,
                                    big: true,
                                    rectangle: true
                                }
                            },
                            appName: 'Rus Imperia'
                        },
                        androidChrome: {
                            pictureAspect: 'shadow',
                            themeColor: '#e8e8dd',
                            manifest: {
                                name: 'Rus Imperia',
                                display: 'standalone',
                                orientation: 'notSet',
                                onConflict: 'override',
                                declared: true
                            },
                            assets: {
                                legacyIcon: false,
                                lowResolutionIcons: false
                            }
                        },
                        safariPinnedTab: {
                            pictureAspect: 'silhouette',
                            themeColor: '#e8e8dd'
                        }
                    },
                    settings: {
                        scalingAlgorithm: 'Mitchell',
                        errorOnImageTooSmall: false,
                        readmeFile: true,
                        htmlCodeFile: true,
                        usePathAsIs: false
                    }
                }
            }
        }
    });

    //~~ Загружаем зависимости из package.json

    for (var key in grunt.file.readJSON('package.json').devDependencies) {
        if (key !== 'grunt' && key.indexOf('grunt') === 0) {
            grunt.loadNpmTasks(key);
        }
    }

    grunt.registerTask( "assembly_lib", [ "uglify:cc_lib", "uglify:min_lib" ] );
    grunt.registerTask( "uglify_ri_dev", [ "jshint", "assembly_lib", "uglify:ri_dev", "uglify:admin" ] );
    grunt.registerTask( "uglify_ri_prod", [ "jshint", "assembly_lib", "uglify:ri_prod", "uglify:admin" ] );
    grunt.registerTask( "assembly_cc_css", [ "concat:common", "autoprefixer:common", "cssmin:common" ] );
    grunt.registerTask( "assembly_adm_css", [ "concat:admin", "autoprefixer:admin", "cssmin:admin" ] );
    grunt.registerTask( "assembly_ri_css", [ "assembly_cc_css", "assembly_adm_css", "concat:ri", "autoprefixer:ri", "cssmin:ri", "concat:ri_auth", "autoprefixer:ri_auth", "cssmin:ri_auth" ] );

    grunt.registerTask( "ri_def", [ "uglify_ri_dev", "assembly_ri_css" ] );
    grunt.registerTask( "ri_prod", [ "uglify_ri_prod", "assembly_ri_css" ] );
};
