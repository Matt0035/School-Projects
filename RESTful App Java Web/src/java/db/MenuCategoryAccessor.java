package db;

import java.sql.Connection;
import java.sql.PreparedStatement;
import java.sql.ResultSet;
import java.sql.SQLException;
import java.util.ArrayList;
import java.util.List;
import entity.MenuItemCategory;

/**
 * This class provides a central location for accessing the MENUITEM table.
 */
public class MenuCategoryAccessor {

    private static Connection conn = null;
    private static PreparedStatement selectAllStatement = null;
    
    // constructor is private - no instantiation allowed
    private MenuCategoryAccessor() {
    }

    /**
     * Used only by methods in this class to guarantee a database connection.
     *
     * @throws SQLException
     */
    private static void init() throws SQLException {
        if (conn == null) {
            conn = ConnectionManager.getConnection(ConnectionParameters.URL, ConnectionParameters.USERNAME, ConnectionParameters.PASSWORD);
            selectAllStatement = conn.prepareStatement("select * from MENUITEMCATEGORY");
        }
    }

    public static List<MenuItemCategory> getAllCategories() {
        List<MenuItemCategory> cats = new ArrayList();
        try {
            init();
            ResultSet rs = selectAllStatement.executeQuery();
            while (rs.next()) {
                String cat = rs.getString("ITEMCATEGORYID");
                String desc = rs.getString("ITEMCATEGORYDESCRIPTION");
                MenuItemCategory tempcat = new MenuItemCategory(cat, desc);
                cats.add(tempcat);
            }
        } catch (SQLException ex) {
            cats = new ArrayList();
        }
        return cats;
    }

} // end MenuCategoryAccessor
