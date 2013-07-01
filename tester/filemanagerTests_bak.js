// My tests for fileManager controller
'use strict';

    describe('Xhr tester', function(){
        var scope, ctrl, httpBackend;

        beforeEach(inject(function($injector,_$httpBackend_, $rootScope, $controller) {
            httpBackend = $injector.get('$httpBackend');
            // $httpBackend = _$httpBackend_;
            httpBackend.whenGET("restserver/listFiles/").respond(200,[{name: 'Nexus S'}, {name: 'Motorola DROID'}]);
            // httpBackend.whenGET("/projects/overview").respond(200, { items: angular.copy(window.RealTestData.ProjectOverview["bebb09c9-5a29-4ce5-a700-8223ee16d770"]) });



            //       $httpBackend.expectGET('restserver/listFiles/').
      //          respond([{name: 'Nexus S'}, {name: 'Motorola DROID'}]);

            scope = $rootScope.$new();
            ctrl = $controller(FileManager, {$scope: scope});

          //  httpBackend = $injector.get('$httpBackend');
          //  scope = $rootScope.$new();
        }));


        it('Skall ladda in två stycken poster i fileList', function() {
            //TODO Lägg till enhetstester för att ladda json
            httpBackend.expectGET('restserver/listFiles/').respond([{name: 'Nexus S'}, {name: 'Motorola DROID'}]);
            scope.getFiles("");
            httpBackend.flush();

            expect(scope.fileList.length).toEqual(2);

        });

        it("Should return the name",function () {
            expect(scope.mittNamn).toMatch("Mattias");
        });

        it("Should return a link to the file (if not dir)",function (){
            var t = scope.getLink("IMG_0963.JPG");

            expect(t).toEqual("http://localhost:8888/filemanager/testmapp/IMG_0963.JPG");
        });

        it("Should return a link to the dir and set of the rest API",function (){
            var t = scope.getLink("ControlCenter3","dir");
            expect(t).toEqual("#");
        });


        it("Add a folder to the current folder array of objects",function (){
            httpBackend.expectGET('restserver/listFiles/ControlCenter3/').respond([{name: 'Nexus S'}, {name: 'Motorola DROID'}]);
            var t = scope.openDir("ControlCenter3");
            httpBackend.flush();
            expect(scope.currentDir).toEqual([{dir:"ControlCenter3"}]);


            httpBackend.expectGET('restserver/listFiles/ControlCenter3/c2/').respond([{name: 'Nexus S'}, {name: 'Motorola DROID'}]);
            var t = scope.openDir("c2");
            httpBackend.flush();
            expect(scope.currentDir).toEqual([{dir:"ControlCenter3"},{dir:"c2"}]);

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
              var test =  scope.slicePath(arr,2);
              expect(test).toEqual([{dir:"c1"},{dir:"c2"}]);
          })

        it("Should slice and update currentPath",function(){
            scope.changePath(scope.currentPath,1)
           // expect(scope.changePath).toHaveBeenCalled();
        });




            /*
             it("should load a new directorylist based on click",function (){
                 var t = scope.goIntoFolder("ControlCenter3","dir");
                 //  expect(t).toEqual("#");

             });
             */


    });

