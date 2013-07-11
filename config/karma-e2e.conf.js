basePath = '../';

files = [
  ANGULAR_SCENARIO,
  ANGULAR_SCENARIO_ADAPTER,
  'test/e2e/**/*.js'
];

autoWatch = false;

browsers = ['Chrome','Firefox','Safari'];

singleRun = true;

proxies = {
  '/': 'http://localhost:8888/filemanager/'
};
// cli runner port
runnerPort = 8888;

// web server port
port = 8888;

junitReporter = {
  outputFile: 'test_out/e2e.xml',
  suite: 'e2e'
};
