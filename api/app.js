import express from 'express';
import cors from 'cors';
import router from './routes/app.routes.js';

const app = express();

const corsOptions = {
  origin: "http://localhost:4200"
};

app.use(cors(corsOptions));
app.use(express.json());
app.use(express.urlencoded({ extended: true }));

// Rutas
// import userRoutes from './routes/user.routes.mjs';
// userRoutes(app);

app.get("/", (req, res) => {
  res.json({ message: "Bienvenido a la API de la tienda de ropa." });
});

// Usar un router de Express para las rutas de la API bajo el prefijo '/api'
app.use('/api', router);

// Middleware de manejo de errores
app.use((err, req, res, next) => {
  console.error(err);
  res.status(500).send({ message: "Ocurrió un error en el servidor", error: err.message });
});

export default app;
