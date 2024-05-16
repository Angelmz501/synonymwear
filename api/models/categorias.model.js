import { DataTypes } from 'sequelize';
import db from '../config/db.config.js';

const Categorias = db.define('Categorias', {
    categoria_id: {
        type: DataTypes.INTEGER,
        primaryKey: true,
        autoIncrement: true
    },
    nombre: {
        type: DataTypes.STRING,
        allowNull: false
    },
    // Añade más campos según sea necesario
}, {
    tableName: 'categorias',
    timestamps: false
});


export default Categorias;