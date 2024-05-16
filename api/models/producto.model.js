import { DataTypes } from 'sequelize';
import db from '../config/db.config.js';
import Categorias from './categorias.model.js';

const Productos = db.define('Productos', {
    producto_id: {
        type: DataTypes.INTEGER,
        primaryKey: true,
        autoIncrement: true
    },
    nombre: {
        type: DataTypes.STRING,
        allowNull: false
    },
    descripcion: {
        type: DataTypes.STRING
    },
    precio: {
        type: DataTypes.DECIMAL(10, 2),
        allowNull: false
    }
    // Añade más campos según sea necesario
}, {
    tableName: 'productos',
    timestamps: false
});

// Establecer la relación
Productos.belongsTo(Categorias, {
    foreignKey: 'categoria_id',
    as: 'categoria'
});

Categorias.hasMany(Productos, {
    foreignKey: 'categoria_id',
    as: 'productos'
});

export default Productos;