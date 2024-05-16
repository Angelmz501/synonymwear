import jwt from "jsonwebtoken";

const secretKey = "clave1234"; // Usa la misma clave que utilizaste para firmar tus tokens JWT

const verifyToken = (req, res, next) => {
  // Lista de rutas que no requieren autenticación
  const publicPaths = ["/login", "/register"];
  const path = req.path.toLowerCase();

  // Continuar sin verificar el token si la ruta es pública
  if (publicPaths.includes(path)) {
    return next();
  }

  const token = req.headers["authorization"]?.split(" ")[1]; // Obtén el token de la cabecera 'Authorization'

  if (!token) {
    return res
      .status(403)
      .send({ message: "Se requiere un token para autenticar" });
  }

  try {
    const decoded = jwt.verify(token, secretKey);
    req.userId = decoded.usuario_id; // Puedes guardar información decodificada del token en el objeto req, si es necesario
    next();
  } catch (error) {
    return res.status(401).send({ message: "Token inválido o expirado" });
  }
};

export default verifyToken;
