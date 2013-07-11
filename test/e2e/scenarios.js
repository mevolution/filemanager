describe('Filemanager App', function() {

    describe('login screen', function() {

        beforeEach(function() {
            browser().navigateTo('index.php');
        });


        it('Should see a login box with two inputs and log in with the wrong password', function() {
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
});
