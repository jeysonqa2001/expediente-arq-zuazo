// PARCIAL 1 · VARIANTE B — Ferretería "El Tornillo"
// Sistema de pedidos de materiales. El código FUNCIONA, pero su diseño tiene
// 4 violaciones de principios SOLID. Tu trabajo: encontrarlas y curar dos.


//Refactorisar
// Aplicacion de principio SOLID
// 1. ISP (Segmentacion de Interfacees), Se separo IEmpleadoDeFerreteria en 2: IRegistradorDePedidos y IEncargadoDeFerreteria.
// 2. DIP (Inversion de Dependencias), Se crearon 2 interfaces: IRepositorioDePedidos y IServiciosDeNotificacion, conectandolas a GFestorDePedidos.

//Refactor: Jeyson Wilfredo Zuazo Mamani
namespace Parcial1.Ferreteria;

// 1. Cura ISP: Se separo las interfaces
public interface IEmpleadoDeFerreteria
{
    void RegistrarPedido(string material, int cantidad);
}

public interface IEncargadoDeFerreteria : IRegistradorDePedidos
{
    void AutorizarVentaAlPorMayor(string material);
    void AjustarPrecio(string material, decimal nuevoPrecio);
    void VerReporteDeCompras();
}

public class Encargado : IEmpleadoDeFerreteria
{
    public void RegistrarPedido(string material, int cantidad)
        => Console.WriteLine($"[ENC] Pedido: {cantidad} x {material}");
    public void AutorizarVentaAlPorMayor(string material)
        => Console.WriteLine($"[ENC] Venta al por mayor de {material} autorizada");
    public void AjustarPrecio(string material, decimal nuevoPrecio)
        => Console.WriteLine($"[ENC] {material} ahora cuesta {nuevoPrecio:0.00} Bs");
    public void VerReporteDeCompras()
        => Console.WriteLine("[ENC] Reporte de compras del mes");
}

public class Vendedor : IEmpleadoDeFerreteria
{
    public void RegistrarPedido(string material, int cantidad)
        => Console.WriteLine($"[VEND] Pedido: {cantidad} x {material}");
}

// Abstraciones iniciales DIP
public interface IRepositorioDePedidos
{
    void GuardarPedido(string cliente, string material, int cantidad, decimal total);
}

public interface IServiciosDeNotificacion
{
    void Enviar(string mensaje);
}

// 2. Curar DIP: MDependencias se inyectan por un constructor
public class GestorDePedidos
{
    private readonly IRepositorioDePedidos _repositorio;
    private readonly IServicioDeNotificacion _notificacion;

    public GestorDePedidos(IRepositorioDePedidos repositorio, IServicioDeNotificacion notificacion)
    {
        _repositorio = repositorio;
        _notificacion = notificacion;
    }

    public void ProcesarPedido(string cliente, string tipoCliente, string material, int cantidad, decimal precioUnitario)
    {
        decimal total = cantidad * precioUnitario;
        decimal descuento = tipoCliente switch
        {
            "contratista" => total * 0.15m,
            "constructora" => total * 0.25m,
            _ => 0m
        };
        decimal totalFinal = total - descuento;

        _repositorio.GuardarPedido(cliente, material, cantidad, totalFinal);

        Console.WriteLine("----- COMPROBANTE -----");
        Console.WriteLine($"{cantidad} x {material}");
        Console.WriteLine($"Cliente: {cliente} ({tipoCliente})");
        Console.WriteLine($"TOTAL: {totalFinal:0.00} Bs");

        _notificacion.Enviar($"Su pedido de {material} fue registrado, {cliente}");
    }
}

public class BaseDeDatosMySql
{
    public void GuardarPedido(string cliente, string material, int cantidad, decimal total)
        => Console.WriteLine($"[MYSQL] INSERT INTO pedidos VALUES ('{cliente}', '{material}', {cantidad}, {total})");
}

public class CorreoSmtp
{
    public void Enviar(string mensaje)
        => Console.WriteLine($"[SMTP] {mensaje}");
}

public static class Demo
{
    public static void Correr()
    {
        new GestorDePedidos().ProcesarPedido("Marco", "contratista", "Cemento 50kg", 10, 62.00m);
    }
}
