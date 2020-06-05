const userShoppingListsContainer = document.querySelector("#about_user_shopping_list");
const userStatisticsContainer = document.querySelector("#about_user_statistics");
const favoriteFoodsContainer = document.querySelector("#about_user_favorite_food");
const favoriteRestaurantsContainer = document.querySelector("#about_user_favorite_restaurants");

favoriteFoodsContainer.addEventListener('click', () => {
    window.open("favorite_food.php");
});

favoriteRestaurantsContainer.addEventListener('click', () => {
    window.open("favorite_restaurant.html");
});

userShoppingListsContainer.addEventListener('click', () => {
    window.open("shopping_list.php");
})

userStatisticsContainer.addEventListener('click', () => {
    window.open("statstics.html");
});