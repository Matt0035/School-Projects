package entity;

public class MenuItem {
    private int id;
    private String category;
    private String description;
    private double price;
    private boolean vegetarian;

    public MenuItem(int id, String category, String description, double price, boolean vegetarian) {
        this.id = id;
        this.category = category;
        this.description = description;
        this.price = price;
        this.vegetarian = vegetarian;
    }

    public int getId() {
        return id;
    }

    public String getCategory() {
        return category;
    }

    public String getDescription() {
        return description;
    }

    public double getPrice() {
        return price;
    }

    public boolean isVegetarian() {
        return vegetarian;
    }
    
} // end class MenuItem
