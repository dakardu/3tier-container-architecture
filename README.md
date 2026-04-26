# 🚀 3-Tier Architecture Evolution: On-Prem → AWS → Containers

Arquitectura de 3 capas lista para producción utilizando NGINX, Apache (x3), MariaDB y Redis completamente contenerizada con Docker.

---

## 🔥 Características

- Balanceo de carga con NGINX
- Alta disponibilidad (3 instancias de aplicación)
- Sesiones compartidas con Redis
- Base de datos persistente (volúmenes de MariaDB)
- Entorno reproducible con Docker Compose

---

## 🏗️ Arquitectura

![Arquitectura](images/architecture.png)

```text
Client → NGINX → app0/app1/app2 → MariaDB
                        ↓
                      Redis
```

## ⚡ Inicio rápido

```bash
git clone https://github.com/dakardu/3tier-container.git
cd 3tier-container
docker compose up -d --build
```

Accede en:

```text
http://localhost
```

## 🧪 Demo

- Balanceo de carga entre app0, app1 y app2
- Sesiones persistentes con Redis

![Demo de balnceo](images/demo.gif)

## 📦 Stack tecnológico

- Docker
- Docker Compose
- NGINX
- Apache HTTP Server
- MariaDB
- Redis

## 🧩 Evolución de la arquitectura

### 🔧 On-Premise (Hyper-V)

- Infraestructura basada en máquinas virtuales
- Configuración manual
- Arquitectura monolítica

### ☁️ Cloud (AWS - Lift & Shift)

- NGINX como reverse proxy
- Cluster Apache
- Base de datos en red privada
- Redis para sesiones
- Segmentación de red (VPC)

### 🐳 Containerización (Docker)

- Migración completa a contenedores
- Docker Compose como orquestador
- Portabilidad entre entornos
- Infraestructura como código

### ⚠️ Problemas reales y soluciones

- Pérdida de sesiones en entorno multi-nodo → solucionado con Redis
- Pérdida de datos al recrear contenedores → solucionado con volúmenes
- Problemas de inicialización de base de datos → solucionado con scripts de entrypoint

## 🚀 Próximos pasos

- Implementar HTTPS (Let's Encrypt)
- Añadir healthchecks
- Pipeline CI/CD (GitHub Actions)
- Despliegue en cloud (OCI / AWS)
- Escalado automático
