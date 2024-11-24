<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //Create Roles
        $adminRole = Role::query()->create(['name' => 'admin']);
        $clientRole = Role::query()->create(['name' => 'client']);
        $sellerRole = Role::query()->create(['name' => 'seller']);
        $guestRole = Role::query()->create(['name' => 'guest']);

        $guestPermissions = [
            'show_all_products', 'show_product', 'get_products_by_category', 'get_products_by_brand', 'search_products', 'get_popular_products', 'get_products_by_category_and_brand',
            'show_all_categories', 'show_category', 'search_by_category',
            'show_brand', 'show_all_brands' ,'search_by_brand' , 'get_brand_by_category',
            'show_trade_page' ,

            'show' , 'getPhotosByProduct', // must be edited
        ];
        //Define Permissions
        $clientPermissions = array_merge($guestPermissions,[
            'login' , 'logout',
            'forget_password' , 'check_code' , 'resend_code' , 'reset_password',
            'redirect_to_google' , 'google_handle_call_back' , 'redirect_to_apple' , 'apple_handle_call_back',
            'update_profile' , 'update_password' ,'delete_my_profile',
            'show_cart' , 'delete_from_cart' , 'add_to_cart' ,
            'checkout' , 'place_order' , 'cancel_placed_order' ,
            'save_address' , 'make_primary' , 'show_addresses' , 'edit_address' , 'delete_address',
            'add_product_to_wishlist' , 'add_offer_to_wishlist' , 'show_wishlist' , 'remove_from_wishlist',
            'show_my_transactions' , 'show_my_wallet' , 'show_coupon',
            'trade_product' , 'edit_trade_product' , 'cancel_trade_product',
            'repair_product' , 'edit_repair_product', 'cancel_repair_order',
        ]);

        $sellerPermissions = array_merge($clientPermissions,[ 'register_as_seller']);//add permissions if I have more for this role

        $adminPermissions = array_merge($clientPermissions ,[
            'show_all_profiles' , 'show_user_profile' , 'delete_profile', 'register_as_client', 'register_as_seller',
            'change_order_status',
            'create_product' , 'update_product' , 'delete_product' ,
            'create_category' , 'update_category' , 'delete_category',
            'create_brand' , 'update_brand' , 'delete_brand',
            'show_user_transactions' , 'show_all_transactions' ,
            'show_user_wallet',
            'show_all_coupons' , 'create_coupon' , 'update_coupon' , 'delete_coupon',
            'change_trade_status' ,
            'change_repair_order_status',

            'create' , 'update' , 'destroy' , 'show' , 'getPhotosByProduct',//must edit - for product photos APIs
        ]);


        foreach ($adminPermissions as $adminPermission){
            Permission::findOrCreate($adminPermission , 'web');
        }

        //Assign Permission To Roles
        $adminRole->syncPermissions($adminPermissions);//delete old permissions and keep the new ones.
        $clientRole->givePermissionTo($clientPermissions);//add permissions with the old ones
        $sellerRole->givePermissionTo([$sellerPermissions]);
        $sellerRole->givePermissionTo([$guestPermissions]);
        ///////////////////////////////////////////

        //create users and assign roles
        $adminUser = User::factory()->create([
            'name' => 'admin',
            'email' => 'admin@mail.com',
            'password' => bcrypt('password'),
        ]);
        $adminUser->assignRole($adminRole);

        //Assign permissions associated with the role to the user
        $permissions = $adminRole->permissions()->pluck('name')->toArray();
        $adminUser->givePermissionTo($permissions);
        $adminUser['token'] = $adminUser->createToken("token")->plainTextToken;


        $clientUser = User::factory()->create([
            'name' => 'client',
            'email' => 'client@mail.com',
            'password' => bcrypt('password'),
        ]);
        $clientUser->assignRole($clientRole);

        $permissions = $clientRole->permissions()->pluck('name')->toArray();
        $clientUser->givePermissionTo($permissions);
        $clientUser['token'] = $clientUser->createToken("token")->plainTextToken;



        $sellerUser = User::factory()->create([
            'name' => 'seller',
            'email' => 'seller@mail.com',
            'password' => bcrypt('password'),
        ]);
        $sellerUser->assignRole($sellerRole);

        $permissions = $sellerRole->permissions()->pluck('name')->toArray();
        $sellerUser->givePermissionTo($permissions);
        $sellerUser['token'] = $sellerUser->createToken("token")->plainTextToken;



    }
}
