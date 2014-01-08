module.exports = function(grunt) {
  // Do grunt-related things in here
  grunt.initConfig({
    // configurações das tasks
    pkg: grunt.file.readJSON('package.json'),
    clean: ['build'],    
    // Compile specified less files
    less: {
      compile: {
        options: {
          // These paths are searched for @imports
          paths: ["public/less"],
          cleancss: true,
        },
        files: {
          "public/css/admin/styles.css": "public/less/admin/main.less"
        }
      }
    },

    watch: {
      options: {livereload: true},
      css: {
        files: ['public/css/**/*.less', 'public/less/**/*.less'],
        tasks: ["less"]
      }
    },

    express: {
      all: {
        options: {
          port: 9000,
          hostname: 'localhost',
          bases: ['.'],
          livereload: true
        }
      }
    }
  });
 
  // Carrega plugins
  grunt.loadNpmTasks('grunt-contrib-less');
  grunt.loadNpmTasks('grunt-contrib-watch');  
  grunt.loadNpmTasks('grunt-express');

  // Carrega plugins Defualt
  grunt.registerTask('default', ['less']);
  grunt.registerTask('server', ['express'], ['watch'])
};
