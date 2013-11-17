basePath = '../';

files = [
  JASMINE,
  JASMINE_ADAPTER,
  'test/lib/angular/angular-1.0.1.min.js',
  'test/lib/angular/angular-mocks.js',
  'plupload/js/plupload.full.js',
  'js/filemanager.js',
  'test/unit/*.js'
];

autoWatch = true;

// browsers = ['Chrome','Firefox','Safari'];
browsers = ['Chrome'];

junitReporter = {
  outputFile: 'test_out/unit.xml',
  suite: 'unit'
};
