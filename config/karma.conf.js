basePath = '../';

files = [
  JASMINE,
  JASMINE_ADAPTER,
  'tester/lib/angular/angular-1.0.1.min.js',
  'tester/lib/angular/angular-mocks.js',
  'plupload/js/plupload.full.js',
  'js/filemanager.js',
  'tester/*.js'
];

autoWatch = true;

browsers = ['Chrome','Firefox','Safari'];

junitReporter = {
  outputFile: 'test_out/unit.xml',
  suite: 'unit'
};
