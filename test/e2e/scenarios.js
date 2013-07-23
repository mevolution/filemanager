describe('Filemanager App:', function() {

  /*  describe('login screen', function() {

        beforeEach(function() {
            browser().navigateTo('index.php');
        });


        it('Should see a login box with two inputs and log in with the wrong password, ', function() {
            input('email').enter('mattias@mevolution.se');
            input('passwd').enter('wrong password');
            element('#login_button', 'login button').click();
            sleep(2);
            expect(element('.alert-error').count()).toBe(1);
        });

        it('Log in with the correct password', function() {
            input('email').enter('mattias@mevolution.se');
            input('passwd').enter('jomen');
            element('#login_button', 'login button').click();
            sleep(2);
            expect(element('#mev_top_site_id').count()).toBe(1);
        });


    });
*/
    describe('Check folder creation and deletion: ',function() {
         beforeEach(function () {
             browser().navigateTo('index.php');
             input('email').enter('mattias@mevolution.se');
             input('passwd').enter('jomen');
             element('#login_button', 'login button').click();
             sleep(2);

         });
        it('Should open a modal and create a new folder',function(){
            element('#top-menu-create-folder a', 'click create new folder button').click()
            sleep(1);
            expect(element('#createFolderModal:visible').count()).toBe(1);
            sleep(1);
            input('input.Folder').enter('test-mappen');
            element('#create-folder-btn', 'Create folder button').click();
            sleep(1);
            expect(element('#createFolderModal:visible').count()).toBe(0);
            sleep(1);
            var r = using('#table-files').repeater('tr:last');
            expect(r.row(0)).toEqual(["test-mappen", "0"]);
        });
        it('Should go into the folder and find it empty',function() {
            pause();
            element('#table-files tr:last-child td.item-link a','Click the Item link in the last row').click();
            sleep(1);
            pause();
            var r = using('#table-files').repeater('tr');
            expect(r.count()).toEqual(1);

        });



    });


});
