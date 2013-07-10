// My tests for fileManager controller
'use strict';

    describe('Xhr tester', function(){
        var scope, ctrl, $httpBackend;

        beforeEach(inject(function(_$httpBackend_, $rootScope, $controller) {
            $httpBackend = _$httpBackend_;
            $httpBackend.expectGET('restServer/listfiles/').respond([{name: 'Nexus S'}, {name: 'Motorola DROID'}]);
            scope = $rootScope.$new();
            ctrl = $controller(FileManager, {$scope: scope});
        }));


        it('Shall load two files into the fileList', function() {
            // TODO Lägg till enhetstester för att ladda json
        });

        it("Should return a link to the file (if not dir)",function (){
            var t = scope.getLink("ControlCenter3/IMG_0963.JPG");
            expect(t).toEqual("/filemanager/testmapp/ControlCenter3/IMG_0963.JPG");
        });

        it("Should return _blank if file and _self if dir)",function (){
            var t = scope.getTarget("dir");
            expect(t).toEqual("_self");
            var t = scope.getTarget("file");
            expect(t).toEqual("_blank");
        });

        it("Should return a link to the dir and set of the rest API",function (){
            var t = scope.getLink("ControlCenter3","dir");
            expect(t).toEqual("#");
        });

        it("Add a folder to the current folder array",function (){
        $httpBackend.expectGET('restServer/listfiles/ControlCenter3/').respond([{name: 'Nexus S'}, {name: 'Motorola DROID'}]);
        var t = scope.openDir("ControlCenter3","dir");
        $httpBackend.flush();
        expect(scope.currentDir[0]).toEqual({dir:"ControlCenter3"});
        });

        it("Should return true if the input is an image", function (){
           var t= _isImage("jpg");
            expect(t).toEqual(true);
            var t= _isImage("png");
            expect(t).toEqual(true);
            var t= _isImage("gif");
            expect(t).toEqual(true);
            var t= _isImage("pdf");
            expect(t).toEqual(false);
        });

        it("Should return an icon or the image depending on extension", function(){
           var t = scope.getIcon("file","DSC_5661.jpg","jpg")
           expect(t).toEqual("/filemanager/testmapp/DSC_5661.jpg");
        });
        it("should return a link to a folder Icon if a folder", function(){
            var t = scope.getIcon("dir","ControlCenter3","");
            expect(t).toEqual("/filemanager/img/folder_icon.png");

        });
        it("should return a link to a pdf Icon if a pdf file", function(){
            var t = scope.getIcon("file","jojjemen.pdf","pdf");
            expect(t).toEqual("/filemanager/img/pdf_icon.jpg");

        });
        it("should return a link to a powerpoint Icon if evrything else", function(){
            var t = scope.getIcon("file","jojjemen.pdf","pptx");
            expect(t).toEqual("/filemanager/img/powerpoint_icon.jpg");
            var t = scope.getIcon("file","jojjemen.pdf","ppt");
            expect(t).toEqual("/filemanager/img/powerpoint_icon.jpg");
        });
        it("should return a link to a excel Icon", function(){
            var t = scope.getIcon("file","jojjemen.xlsx","xlsx");
            expect(t).toEqual("/filemanager/img/excel_icon.jpg");
            var t = scope.getIcon("file","jojjemen.xlsx","xls");
            expect(t).toEqual("/filemanager/img/excel_icon.jpg");

        });
        it("should return a link to a word Icon", function(){
            var t = scope.getIcon("file","jojjemen.pdf","docx");
            expect(t).toEqual("/filemanager/img/word_icon.jpg");
            var t = scope.getIcon("file","jojjemen.pdf","doc");
            expect(t).toEqual("/filemanager/img/word_icon.jpg");
        });
        it("should return a link to a file Icon if evrything else", function(){
            var t = scope.getIcon("file","jojjemen.pdf","xxx");
           expect(t).toEqual("/filemanager/img/document_icon.png");

        });

        // My e2e tests
/*
        describe('Filemanager', function() {
            it('should list 4 items in the filelist', function() {
                expect(repeater('ul li').count()).toEqual(10);
            });
        });

*/

    });

