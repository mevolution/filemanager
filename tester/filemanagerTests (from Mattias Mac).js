// My tests for fileManager controller
'use strict';

    describe('Filemanager Dir listings', function(){
        var scope, ctrl, httpBackend;
        beforeEach(inject(function($injector,_$httpBackend_, $rootScope, $controller) {
           httpBackend = $injector.get('$httpBackend');
           httpBackend.whenGET("restserver/listFiles/").respond(200,[{name: 'Nexus S'}, {name: 'Motorola DROID'}]);
            //       $httpBackend.expectGET('restserver/listFiles/').
      //          respond([{name: 'Nexus S'}, {name: 'Motorola DROID'}]);

            scope = $rootScope.$new();
            ctrl = $controller(FileManager, {$scope: scope});

          //  httpBackend = $injector.get('$httpBackend');
          //  scope = $rootScope.$new();
        }));

        it("Should return a link to the file (if not dir)",function (){
            var t = scope.getLink("IMG_0963.JPG");

            expect(t).toEqual("http://localhost:8888/filemanager/testmapp/IMG_0963.JPG");
        });
        it("Should return a link to the dir and set of the rest API",function (){
            var t = scope.getLink("ControlCenter3","dir");
            expect(t).toEqual("#");
        });
        it("check function to convert array to string", function() {
            var arr = [];
            arr.push({dir:"c1"});
            arr.push({dir:"c2"});
            var test =  _arrayToString(arr,"dir","/");
            expect(test).toMatch("c1/c2");

        });
        it("Should slice the path at given level",function(){
              var arr = [];
              arr.push({dir:"c1"});
              arr.push({dir:"c2"});
              arr.push({dir:"c3"});
              var test =  _slicePath(arr,2);
              expect(test).toEqual([{dir:"c1"},{dir:"c2"}]);
          })
        it("Should slice and update currentPath",function(){
            scope.changePath(scope.currentPath,1)
           // expect(scope.changePath).toHaveBeenCalled();
        });

    });

    describe('Filemanager Fileoperations', function(){
        var scope, ctrl, httpBackend;
        beforeEach(inject(function($injector,_$httpBackend_, $rootScope, $controller) {
            httpBackend = $injector.get('$httpBackend');
            httpBackend.whenGET("restserver/listFiles/").respond(200,[{name: 'Nexus S'}, {name: 'Motorola DROID'}]);
            var json="";
          //  var ut = 'json={"src":"/testfile.txt","dest":"/scan/testfile.txt"}';
           // httpBackend.whenPOST("restserver/moveFiles/",ut).respond(200,"1");

            scope = $rootScope.$new();
            ctrl = $controller(FileManager, {$scope: scope});
        }));

        it('Skall ladda in två stycken poster i fileList', function() {
            //TODO Lägg till enhetstester för att ladda json
    //            httpBackend.expectGET('restserver/listFiles/').respond([{name: 'Nexus S'}, {name: 'Motorola DROID'}]);
            httpBackend.expectGET('restserver/listFiles/');
            scope.getFiles("");
            httpBackend.flush();
            expect(scope.fileList.length).toEqual(2);
        });
        it("Add a folder to the current folder",function (){
            httpBackend.expectGET('restserver/listFiles/ControlCenter3/').respond([{name: 'Nexus S'}, {name: 'Motorola DROID'}]);
            var t = scope.openDir("ControlCenter3");
            httpBackend.flush();
            expect(scope.currentDir).toEqual([{dir:"ControlCenter3"}]);

            httpBackend.expectGET('restserver/listFiles/ControlCenter3/c2/').respond([{name: 'Nexus S'}, {name: 'Motorola DROID'}]);
            var t = scope.openDir("c2");
            httpBackend.flush();
            expect(scope.currentDir).toEqual([{dir:"ControlCenter3"},{dir:"c2"}]);

        });

        /*
        it("Should move the testfile.txt from root to the scan folder",function() {
            scope.status ="";
            var json ="";
            var ut = 'json={"src":"/testfile.txt","dest":"/scan/testfile.txt"}';
            httpBackend.expectPUT('restserver/moveFile/',ut).respond(200,1);
            _moveFile("/testfile.txt","/scan/testfile.txt");
            expect(scope.status).toEqual("");
            httpBackend.flush();
            expect(scope.status).toEqual("File uploaded!");
        })
        */

        describe('Filemanager general functions', function(){
            var scope, ctrl,httpBackend;
            beforeEach(inject(function($injector,_$httpBackend_, $rootScope, $timeout, $controller) {
                scope = $rootScope.$new();
                var ctrl = $controller(FileManager, {
                    $scope: scope,
                    $timeout: $timeout
                });

            }));

            /*
            it("Should return $scope status, ok! and errror!",function (){
                scope.setStatus("ok!");
                expect(scope.status).toEqual("ok!");
                scope.setStatus("error!");
                expect(scope.status).toEqual("error!");
            });


            it("Should return $scope status, ok! and clear it after 1000ms if timeout is given",inject(function($timeout){
                scope.setStatus("ok!",2);
                expect(scope.status).toEqual("ok!");
                $timeout.flush();
                expect(scope.status).toEqual("");
            }));

             */

            it("should return image tag if the file is an image, size from global settings.", function (){

                t = scope.getIcon("dir","ocr","");
                expect(t).toEqual("<img src='http://localhost/filemanager/img/folder.jpg   '");

            });







        });

 });