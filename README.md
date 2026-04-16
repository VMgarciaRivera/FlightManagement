# ✈️ API de Gestión de Vuelos - Arquitectura Hexagonal

Este repositorio contiene una implementación profesional de un backend para la gestión de vuelos y autenticación de usuarios. El objetivo principal del proyecto es demostrar la aplicación de Clean Architecture y patrones de diseño avanzados en PHP nativo.

---

## 🎯 Propósito del Proyecto

El sistema permite administrar el ciclo de vida de los vuelos y la seguridad de los usuarios mediante un enfoque **Stateless (sin estado)**.

A diferencia de las aplicaciones tradicionales basadas en sesiones de servidor (`$_SESSION`), esta API utiliza **Bearer Tokens persistentes en base de datos** para garantizar la escalabilidad y la seguridad en cada petición.

---

## 🏗️ Arquitectura y Diseño de Software

El proyecto está estructurado bajo el patrón de **Arquitectura Hexagonal (Puertos y Adaptadores)**, dividiendo el código en tres capas fundamentales para garantizar un bajo acoplamiento:

### 1. Capa de Dominio (`src/Domain`)

Es el núcleo de la aplicación. Contiene:

* Entidades (como `User` y `Flight`)
* Interfaces (Puertos) que definen los contratos de los repositorios y servicios externos

Esta capa es totalmente independiente de cualquier framework o base de datos.

---

### 2. Capa de Aplicación (`src/Application`)

Contiene la lógica de negocio orquestada en **Casos de Uso (Servicios)**. Aquí se gestionan procesos como:

* **Autenticación:** Validación de credenciales y generación de tokens criptográficamente seguros
* **Recuperación de Cuenta:** Lógica para el manejo de `reset_tokens` de un solo uso
* **Gestión de Vuelos:** Reglas para la creación y listado de vuelos

---

### 3. Capa de Infraestructura (`src/Infrastructure`)

Contiene las implementaciones técnicas (**Adaptadores**). Es la única capa que conoce los detalles externos:

* **Persistencia:** Repositorios que implementan SQL para PostgreSQL usando PDO
* **Servicios Externos:** Adaptadores para el envío de correos y cargadores de configuración dinámica (`.env`)
* **Configuración:** Gestión de la conexión a la base de datos y variables de entorno

---

## 🔒 Sistema de Seguridad y Autenticación

El repositorio implementa un flujo de seguridad completo:

* **Middleware de Autenticación:**
  Interceptor centralizado que valida el token en el encabezado `Authorization` antes de permitir el acceso a los controladores

* **Protección de Datos:**
  Hasheo de contraseñas mediante el algoritmo **BCRYPT**

* **Control de Sesión:**
  Capacidad de invalidar tokens de acceso (**Logout**) y tokens de recuperación (**Reset Password**) directamente desde la persistencia

* **Inyección de Dependencias:**
  Uso de un `DependencyContainer` para gestionar la creación de objetos y desacoplar las clases

---

## 📂 Organización del Repositorio

```
/src
  ├── Domain
  ├── Application
  ├── Infrastructure
  └── Common

/public
  └── index.php

.env.example
```

* `/src`: Código fuente organizado por capas (Domain, Application, Infrastructure)
* `/public`: Punto de entrada único (`index.php`) que funciona como enrutador y guardián de seguridad
* `.env.example`: Plantilla de configuración para variables de entorno

---

## 🛠️ Tecnologías Utilizadas

* **Lenguaje:** PHP 8.1+

* **Motor de BD:** PostgreSQL

* **Patrones:**

  * Singleton
  * Repository Pattern
  * Dependency Injection
  * Hexagonal Architecture

* **Seguridad:**

  * Bearer Token Auth
  * BCRYPT Hashing

---
