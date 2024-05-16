import { DataTypes } from 'sequelize';
import db from '../config/db.config.js';


const Usuarios = db.define('Usuarios', {
    usuario_id: {
        type: DataTypes.INTEGER,
        primaryKey: true,
        autoIncrement: true
    },
    nombre: {
        type: DataTypes.STRING,
        allowNull: false
    },
    email: {
        type: DataTypes.STRING,
        allowNull: false,
        unique: true
    },
    password: {
        type: DataTypes.STRING,
        allowNull: false
    }
}, {
    // Opciones adicionales
    tableName: 'usuarios',
    timestamps: false // Para no usar las columnas de timestamps automáticas de Sequelize (createdAt, updatedAt)
});

export default Usuarios;