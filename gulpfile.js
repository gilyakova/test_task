gulp = require('gulp');
rename = require('gulp-rename');
plumber = require('gulp-plumber');

sass = require('gulp-sass');
prefix = require('gulp-autoprefixer');

uglify = require('gulp-uglify');
concat = require('gulp-concat');

sprite = require('gulp.spritesmith');
imgmin = require('gulp-imagemin');

gulp.task('default', ['watch']);

gulp.task('watch', function() {
	gulp.watch('public/assets/js/**/*.js', {cwd: './'}, ['js']);
	gulp.watch('public/assets/**/*.scss', {cwd: './'}, ['sass']);
	gulp.watch('public/assets/sprite/**/*.png', {cwd: './'}, ['sprite']);

	//only for adding
	gulp.watch('public/assets/img/**/*.*', {cwd: './'}, function(event) {
		if (event.type === 'added') {
			gulp.start('imgmin');
		}
	});
});

gulp.task('build', ['sprite', 'js-vendor', 'js', 'sass']);

gulp.task('js', function() {
	gulp.src([
		'public/assets/js/vendor.min.js',
		'public/assets/js/custom.js'
	])
		.pipe(plumber())
		.pipe(uglify())
		.pipe(concat('script.min.js'))
		.pipe(gulp.dest('public/assets/dist/'))
});

gulp.task('js-vendor', function() {
	gulp.src([
		'public/assets/vendor/jquery/dist/jquery.js',
		'public/assets/vendor/jquery-ui/jquery-ui.js',
		'public/assets/vendor/tether/dist/js/tether.js',
		'public/assets/vendor/bootstrap/dist/js/bootstrap.js',
		'public/assets/vendor/jquery.maskedinput/dist/jquery.maskedinput.min.js',
		'public/assets/vendor/rippleria/js/jquery.rippleria.js'
	])
		.pipe(plumber())
		.pipe(uglify())
		.pipe(concat('vendor.min.js'))
		.pipe(gulp.dest('public/assets/js/'))
});

gulp.task('sass', function() {
	gulp.src('public/assets/style.scss')
		.pipe(plumber())
		.pipe(sass({outputStyle: 'compressed'}))
		.pipe(prefix())
		.pipe(rename('style.min.css'))
		.pipe(gulp.dest('public/assets/dist/'))
});

gulp.task('sprite', function() {
	var spriteData = gulp.src('public/assets/sprite/**/*.png')
		.pipe(plumber())
		.pipe(sprite({
			imgName: 'sprite.png',
			imgPath: 'public/assets/img/',
			cssName: '_sprite.scss',
			cssPath: 'public/assets/sass/base/'
		}));

	var imgStream = spriteData.img
		.pipe(gulp.dest('public/assets/img/'))

	var cssStream = spriteData.css
		.pipe(gulp.dest('public/assets/sass/template/'))
});

gulp.task('imgmin', function() {
	gulp.src('public/assets/img/*')
		.pipe(plumber())
		.pipe(imgmin([
			imgmin.gifsicle({interlaced: true}),
			imgmin.jpegtran({progressive: true}),
			imgmin.optipng({optimizationLevel: 5}),
			imgmin.svgo({plugins: [{removeViewBox: true}]})
		]))
		.pipe(gulp.dest('public/assets/img'))
});