import Usuario from "../models/usuario.model.js";
import bcrypt from "bcryptjs";
import jwt from "jsonwebtoken";

const SECRET_KEY = "clave1234";

// Función para registrar un nuevo usuario
export async function register(req, res) {
  try {
    // Hashear la contraseña
    const hashedPassword = bcrypt.hashSync(req.body.password, 8);

    // Crear un nuevo usuario
    const usuario = await Usuario.create({
      nombre: req.body.nombre,
      email: req.body.email,
      password: hashedPassword,
    });

    // Enviar respuesta
    res.status(201).send({
      message: "Usuario registrado exitosamente!",
      usuarioId: usuario.usuario_id,
    });
  } catch (error) {
    res.status(500).send({ message: "Error al registrar el usuario", error });
  }
}

export async function login(req, res) {
  try {
    // Buscar el usuario por email
    const usuario = await Usuario.findOne({ where: { email: req.body.email } });

    // Verificar si el usuario existe
    if (!usuario) {
      return res.status(404).send({ message: "Usuario no encontrado" });
    }

    // Verificar la contraseña
    const passwordIsValid = bcrypt.compareSync(
      req.body.password,
      usuario.password
    );

    if (!passwordIsValid) {
      return res.status(401).send({ auth: false, token: null });
    }

    // Generar un nuevo token JWT
    const token = jwt.sign({ usuario_id: usuario.usuario_id }, SECRET_KEY, {
      expiresIn: 86400, // expira en 24 horas
    });

    // Enviar respuesta (en un caso real, aquí se generaría un token JWT)
    res.status(200).send({
      id: usuario.usuario_id,
      auth: true,
      jwt: token,
      message: "Inicio de sesión exitoso!",
    });
  } catch (error) {
    res.status(500).send({ message: "Error en el inicio de sesión" });
  }
}
