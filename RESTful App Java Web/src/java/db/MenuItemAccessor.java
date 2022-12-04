package db;

import java.sql.Connection;
import java.sql.PreparedStatement;
import java.sql.ResultSet;
import java.sql.SQLException;
import java.util.ArrayList;
import java.util.List;
import entity.MenuItem;

/**
 * This class provides a central location for accessing the MENUITEM table.
 */
public class MenuItemAccessor {

    private static Connection conn = null;
    private static PreparedStatement selectAllStatement = null;
    private static PreparedStatement deleteStatement = null;
    private static PreparedStatement insertStatement = null;
    private static PreparedStatement updateStatement = null;

    // constructor is private - no instantiation allowed
    private MenuItemAccessor() {
    }

    /**
     * Used only by methods in this class to guarantee a database connection.
     *
     * @throws SQLException
     */
    private static void init() throws SQLException {
        if (conn == null) {
            conn = ConnectionManager.getConnection(ConnectionParameters.URL, ConnectionParameters.USERNAME, ConnectionParameters.PASSWORD);
            selectAllStatement = conn.prepareStatement("select * from MENUITEM");
            deleteStatement = conn.prepareStatement("delete from MENUITEM where ITEMID = ?");
            insertStatement = conn.prepareStatement("insert into MENUITEM values (?,?,?,?,?)");
            updateStatement = conn.prepareStatement("update MENUITEM set ITEMCATEGORYID = ?, DESCRIPTION = ?, PRICE = ?, VEGETARIAN = ? where ITEMID = ?");
        }
    }

    /**
     * Gets all menu items.
     *
     * @return a List, possibly empty, of MenuItem objects
     */
    public static List<MenuItem> getAllMenuItems() {
        List<MenuItem> items = new ArrayList();
        try {
            init();
            ResultSet rs = selectAllStatement.executeQuery();
            while (rs.next()) {
                int id = rs.getInt("ITEMID");
                String cat = rs.getString("ITEMCATEGORYID");
                String desc = rs.getString("DESCRIPTION");
                double price = rs.getDouble("PRICE");
                boolean veg = rs.getBoolean("VEGETARIAN");
                MenuItem item = new MenuItem(id, cat, desc, price, veg);
                items.add(item);
            }
        } catch (SQLException ex) {
            items = new ArrayList();
        }
        return items;
    }

    /**
     * Deletes the MenuItem with the same ID as the specified item.
     *
     * @param item the item whose ID should be used to match the item to delete
     * @return <code>true</code> if an item was deleted; <code>false</code>
     * otherwise
     */
    public static boolean deleteItem(MenuItem item) {
        boolean res;

        try {
            init();
            deleteStatement.setInt(1, item.getId());
            int rowCount = deleteStatement.executeUpdate();
            res = (rowCount == 1);
        } catch (SQLException ex) {
            res = false;
        }
        return res;
    }

    /**
     * Deletes the MenuItem with the specified ID.
     *
     * @param id the ID of the item to delete
     * @return <code>true</code> if an item was deleted; <code>false</code>
     * otherwise
     */
    public static boolean deleteItemById(int id) {
        MenuItem dummy = new MenuItem(id, "dummyCategory", "dummyDescription", 0.0, false);
        return deleteItem(dummy);
    }
    
    public static boolean insertItem(MenuItem item) {
        boolean res;
        
        try {
            init();
            insertStatement.setInt(1, item.getId());
            insertStatement.setString(2, item.getCategory());
            insertStatement.setString(3, item.getDescription());
            insertStatement.setDouble(4, item.getPrice());
            insertStatement.setBoolean(5, item.isVegetarian());
            int rowCount = insertStatement.executeUpdate();
            res = (rowCount == 1);
        }
        catch (SQLException ex) {
            res = false;
        }
        
        return res;
    }

    public static boolean updateItem(MenuItem item) {
        boolean res;
        
        try {
            init();
            updateStatement.setString(1, item.getCategory());
            updateStatement.setString(2, item.getDescription());
            updateStatement.setDouble(3, item.getPrice());
            updateStatement.setBoolean(4, item.isVegetarian());
            updateStatement.setInt(5, item.getId());
            int rowCount = updateStatement.executeUpdate();
            res = (rowCount == 1);
        }
        catch (SQLException ex) {
            res = false;
        }
        
        return res;
    }

} // end MenuItemAccessor
