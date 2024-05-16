import { Router } from "express";
import { login, register } from "../controllers/auth.controller.js";
import { getProducts, getCategorias } from "../controllers/producto.controller.js";
import verifyToken from "../middlewares/auth.middleware.js";

const router = Router();

// Aplica el middleware de autenticación a todas las rutas
router.use(verifyToken);

// Ruta de registro
router.post("/register", register);

// Ruta de login
router.post("/login", login);

// Ruta de get de productos
router.get("/productos", getProducts);

// Ruta de get de categorias de producto
router.get("/categorias", getCategorias);

export default router;
