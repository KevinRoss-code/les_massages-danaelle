

module.exports = (sequelize, DataTypes) => {
    const User = sequelize.define("user", {
        name: {
            type: DataTypes.STRING
        },
        surname: {
            type: DataTypes.STRING
        },
        email: {
            type: DataTypes.STRING
        },
        password: {
            type: DataTypes.STRING
        },
        // isAdmin: {
        //     type: DataTypes.BOOLEAN,
        //     defaultValue: false
        // }
    });

    return User;
}