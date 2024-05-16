import app from './app.js';
import db from './config/db.config.js';

const PORT = process.env.PORT || 3000;


// Probar la conexión a la base de datos antes de iniciar el servidor
db.authenticate()
  .then(() => {
    console.log('Conexión a la base de datos establecida exitosamente.');

    // Sincronizar todos los modelos con la base de datos
    return db.sync(); // Usar 'db.sync({ force: true })' solo si deseas forzar la sincronización, lo que puede eliminar datos existentes.
  })
  .then(() => {
    console.log('Sincronización de la base de datos exitosa. Todos los modelos fueron inicializados.');

    // Iniciar el servidor solo si la conexión a la base de datos es exitosa
    app.listen(PORT, () => {
      console.log(`El servidor está corriendo en: http://localhost:${PORT}`);
    });
  })
  .catch(err => {
    console.error('No se pudo conectar a la base de datos:', err);
  });