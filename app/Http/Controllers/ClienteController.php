<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreClienteRequest;
use App\Http\Requests\EditClienteRequest;
use App\Http\Requests\GetSimulacionHipotecaRequest;
use App\Models\Cliente;
use App\Models\SimulacionHipoteca;
use Illuminate\Http\Request;
use OpenApi\Annotations as OA;

/**
 * @OA\Info(
 *     title="Simulador Hipotecas Api Rest",
 *     version="0.1",
 * ),
 *  @OA\Server(
 *      description="Localhost env",
 *      url="http://127.0.0.1:8000/api/"
 *  ),
 */
class ClienteController extends Controller
{


    /**
     * @OA\Get(
     *     path="/clientes",
     *     summary="Obtener dnis de clientes",
     *     description="Devuelve los dnis de los clientes existentes",
     *     operationId="index",
     *     tags={Cliente},
     *     @OA\Response(
     *         response="200",
     *         description="Clientes obtenidos con éxito",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="status",
     *                 type="number",
     *                 example="200"
     *             ),
     *             @OA\Property(
     *                 property="response",
     *                 type="array",
     *                 @OA\Items(
     *                      @OA\Property(property="ID_cliente",type="number"),
     *                      @OA\Property(property="dni",type="string"),
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="No hay clientes registrados",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="status",
     *                 type="number",
     *                 example="404"
     *             ),
     *             @OA\Property(
     *                 property="error",
     *                 type="string",
     *                 example="No hay clientes registrados"
     *             )
     *         )
     *     )
     * )
     */
    public function index()
    {
        $clientes = Cliente::get();
        if (sizeof($clientes) != 0) {
            foreach ($clientes as $cliente) {
                unset($cliente['nombre']);
                unset($cliente['email']);
                unset($cliente['capital_solicitado']);
            }
            return response()->json(['status' => 200, 'response' => $clientes], 200);
        } else {
            return response()->json(['status' => 404, 'error' => 'No hay clientes registrado'], 404);
        }
    }

    /**
     * @OA\Post(
     *     path="/clientes",
     *     summary="Creación de un nuevo cliente",
     *     description="Creación de un nuevo cliente no existente en la base de datos",
     *     operationId="store",
     *     tags={Cliente},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="nombre", type="string", example="Pepe"),
     *             @OA\Property(property="dni", uniqueItems=true, format="dni", type="string", example="12345678Z" ),
     *             @OA\Property(property="email", format="email", type="string", example="pepe@gmail.com"),
     *             @OA\Property(property="capital_solicitado", type="number", minimum=0, format="float", example="200000"),
     *             required={"nombre", "dni", "email", "capital_solicitado"}
     *         )
     *     ),
     *     @OA\Response(
     *         response="201",
     *         description="Cliente creado con éxito",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="status",
     *                 type="number",
     *                 example="201"
     *             ),
     *             @OA\Property(
     *                 property="response",
     *                 type="object",
     *                 @OA\Property(property="nombre", type="string", example="Pepe"),
     *                 @OA\Property(property="dni", type="string", example="12345678Z"),
     *                 @OA\Property(property="email", type="string", example="pepe@gmail.com"),
     *                 @OA\Property(property="capital_solicitado", type="number", format="float", example="200000")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response="422",
     *         description="Contenido Inprocesable",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="The x field {error type}"),
     *             @OA\Property(
     *                 property="errors",
     *                 type="array",
     *                 @OA\Items(
     *                     type="object",
     *                     @OA\Property(
     *                         property="error_field",
     *                         example="The x field {error type}"
     *                     )
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response="500",
     *         description="Error Interno"
     *     )
     * )
     */
    public function store(StoreClienteRequest $request)
    {
        $clienteArray = array(
            "nombre" => $request->nombre,
            "dni" => $request->dni,
            "email" => $request->email,
            "capital_solicitado" => $request->capital_solicitado,
        );
        $cliente = Cliente::create($clienteArray);
        if ($cliente) {
            return response()->json(['status' => 201, 'response' => $cliente], 201);
        } else {
            return response()->json(['status' => 500, 'error' => 'Error Interno'], 500);
        }
    }

    /**
     * @OA\Get(
     *     path="/clientes/{dni}",
     *     summary="Obtener información de un cliente",
     *     description="Devuelve información detallada de un cliente según su dni",
     *     operationId="show",
     *     tags={Cliente},
     *     @OA\Parameter(
     *         name="dni",
     *         in="path",
     *         description="DNI del cliente a buscar",
     *         required=true,
     *         @OA\Schema(
     *             type="string",
     *             format="dni",
     *         ),
     *         example="52696831J"
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="Cliente creado con éxito",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="status",
     *                 type="number",
     *                 example="200"
     *             ),
     *             @OA\Property(
     *                 property="response",
     *                 type="object",
     *                 @OA\Property(property="ID_cliente",type="number"),
     *                 @OA\Property(property="nombre",type="string"),
     *                 @OA\Property(property="dni",type="string"),
     *                 @OA\Property(property="email",type="string"),
     *                 @OA\Property(property="capital_solicitado",type="number",format="float"),
     *                 @OA\Property(property="simulaciones_hipotecas",type="array",
     *                     @OA\Items(
     *                         type="object",
     *                         @OA\Property(property="ID_simulacion",type="number"),
     *                         @OA\Property(property="FK_cliente",type="number"),
     *                         @OA\Property(property="tae",type="number",format="float"),
     *                         @OA\Property(property="plazo_amortizacion",type="integer"),
     *                         @OA\Property(property="cuota",type="number",format="float"),
     *                         @OA\Property(property="importe",type="number",format="float")
     *                     )
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Cliente no encontrado",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="status",
     *                 type="number",
     *                 example="404"
     *             ),
     *             @OA\Property(
     *                 property="error",
     *                 type="string",
     *                 example="Cliente no encontrado"
     *             )
     *         )
     *     )
     * )
     */
    public function show($dni)
    {
        $cliente = Cliente::where('dni', $dni)->with('simulaciones_hipotecas')->first();
        if ($cliente) {
            return response()->json(['status' => 200, 'response' => $cliente], 200);
        } else {
            return response()->json(['status' => 404, 'error' => 'Cliente no encontrado'], 404);
        }
    }

    /**
     * @OA\Put(
     *     path="/clientes/{dni}",
     *     summary="Actualizar la información de un cliente",
     *     description="Actualizar la información de un cliente existente en la base de datos",
     *     operationId="update",
     *     tags={Cliente},
     *     @OA\Parameter(
     *         name="dni",
     *         in="path",
     *         description="DNI del cliente a actualizar",
     *         required=true,
     *         @OA\Schema(
     *             type="string",
     *             format="dni",
     *         ),
     *         example="52696831J"
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="nombre", type="string", example="LuisEdited"),
     *             @OA\Property(property="dni", uniqueItems=true, format="dni", type="string", example="52696831J" ),
     *             @OA\Property(property="email", format="email", type="string", example="luis_garcia@gmail.com"),
     *             @OA\Property(property="capital_solicitado", type="number", minimum=0, format="float", example="200000"),
     *             required={"nombre", "dni", "email", "capital_solicitado"}
     *         )
     *     ),
     *     @OA\Response(
     *         response="201",
     *         description="Cliente creado con éxito",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="status",
     *                 type="number",
     *                 example="201"
     *             ),
     *             @OA\Property(
     *                 property="response",
     *                 type="object",
     *                 @OA\Property(property="nombre", type="string", example="LuisEdited"),
     *                 @OA\Property(property="dni", type="string", example="52696831J"),
     *                 @OA\Property(property="email", type="string", example="luis_garcia@gmail.com"),
     *                 @OA\Property(property="capital_solicitado", type="number", format="float", example="200000")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response="422",
     *         description="Contenido Inprocesable",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="The x field {error type}"),
     *             @OA\Property(
     *                 property="errors",
     *                 type="array",
     *                 @OA\Items(
     *                     type="object",
     *                     @OA\Property(
     *                         property="error_field",
     *                         example="The x field {error type}"
     *                     )
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Cliente no encontrado",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="status",
     *                 type="number",
     *                 example="404"
     *             ),
     *             @OA\Property(
     *                 property="error",
     *                 type="string",
     *                 example="Cliente no encontrado"
     *             )
     *         )
     *     )
     * )
     */
    public function update(Request $request, string $dni)
    {
        $cliente = Cliente::where('dni', $dni)->first();
        if ($cliente) {
            $editClientRequest = new EditClienteRequest($cliente->ID_cliente);
            $validatedData = $request->validate($editClientRequest->rules());
            Cliente::where('dni', $dni)->update([
                "nombre" => $validatedData['nombre'],
                "dni" => $validatedData['dni'],
                "email" => $validatedData['email'],
                "capital_solicitado" => $validatedData['capital_solicitado'],
            ]);
            $cliente = Cliente::where('dni', $request->dni)->first();
            return response()->json(['status' => 201, 'response' => $cliente], 201);
        } else {
            return response()->json(['status' => 404, 'error' => 'Cliente no encontrado'], 404);
        }
    }

    /**
     * @OA\Delete(
     *     path="/clientes/{dni}",
     *     summary="Elimina un cliente",
     *     description="Elimina un cliente existente por su DNI",
     *     operationId="destroy",
     *     tags={Cliente},
     *     @OA\Parameter(
     *         name="dni",
     *         in="path",
     *         description="DNI del cliente a eliminar",
     *         required=true,
     *         @OA\Schema(
     *             type="string",
     *             format="dni",
     *         ),
     *         example="12345678Z"
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Cliente y simulaciones eliminados con éxito",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="status",
     *                 type="number",
     *                 example="200"
     *             ),
     *             @OA\Property(
     *                 property="error",
     *                 type="string",
     *                 example="Cliente y simulaciones eliminados con éxito"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Cliente no encontrado",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="status",
     *                 type="number",
     *                 example="404"
     *             ),
     *             @OA\Property(
     *                 property="error",
     *                 type="string",
     *                 example="Cliente no encontrado"
     *             )
     *         )
     *     )
     * )
     */
    public function destroy(string $dni)
    {
        $cliente = Cliente::where('dni', $dni)->with('simulaciones_hipotecas')->first();
        if ($cliente) {
            foreach ($cliente->simulaciones_hipotecas as $simulacion) {
                $simulacion->delete();
            }
            $cliente->delete();
            return response()->json(['status' => 200, 'response' => 'Cliente y simulaciones eliminados con éxito'], 200);
        } else {
            return response()->json(['status' => 404, 'error' => 'Cliente no encontrado'], 404);
        }
    }


    /**
     * @OA\Post(
     *     path="/simulacion-hipoteca/{dni}",
     *     summary="Genera una simulación de hipoteca",
     *     description="Genera una simulación de hipoteca de un cliente existente",
     *     operationId="simulacionHipoteca",
     *     tags={SimulacionHipoteca},
     *     @OA\Parameter(
     *         name="dni",
     *         in="path",
     *         description="DNI del cliente deseado",
     *         required=true,
     *         @OA\Schema(
     *             type="string",
     *             format="dni",
     *         ),
     *         example="52696831J"
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         description="Datos de la hipoteca",
     *         @OA\JsonContent(
     *             required={"tae","plazo_amortizacion"},
     *             @OA\Property(property="tae", type="number", minimum=0, format="float", example="5"),
     *             @OA\Property(property="plazo_amortizacion", minimum=0, type="integer", example="15")
     *         )
     *     ),
     *     @OA\Response(
     *         response="201",
     *         description="Simulación de hipoteca generada con éxito",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="status",
     *                 type="number",
     *                 example="201"
     *             ),
     *             @OA\Property(
     *                 property="response",
     *                 type="object",
     *                 @OA\Property(property="tae", type="number", format="float", example="5"),
     *                 @OA\Property(property="plazo_amortizacion", type="integer", example="15"),
     *                 @OA\Property(property="cuota_mensual", type="number", format="float", example="790.794"),
     *                 @OA\Property(property="importe_total_devolucion", type="number", format="float", example="42342.853")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Cliente no encontrado",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="status",
     *                 type="number",
     *                 example="404"
     *             ),
     *             @OA\Property(
     *                 property="error",
     *                 type="string",
     *                 example="Cliente no encontrado"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Error interno del servidor"
     *     )
     * )
     */
    public function simulacionHipoteca(GetSimulacionHipotecaRequest $request, $dni)
    {
        $cliente = Cliente::where('dni', $dni)->first();
        if ($cliente) {
            $cuota = $this->getCuotaHipoteca($request->tae, $request->plazo_amortizacion, $cliente->capital_solicitado);
            $importeTotalDevolucion = $this->getImporteDevolucion($cuota, $request->plazo_amortizacion, $cliente->capital_solicitado);
            $simulacionArray = array(
                "FK_cliente" => $cliente->ID_cliente,
                "tae" => $request->tae,
                "plazo_amortizacion" => $request->plazo_amortizacion,
                "cuota_mensual" => round($cuota, 3),
                "importe_total_devolucion" => round($importeTotalDevolucion, 3)
            );
            $simulacion = SimulacionHipoteca::create($simulacionArray);
            if ($simulacion) {
                $simulacionResponse = array(
                    "tae" => $simulacion->tae,
                    "plazo_amortizacion" => $simulacion->plazo_amortizacion,
                    "cuota_mensual" => $simulacion->cuota_mensual,
                    "importe_total_devolucion" => $simulacion->importe_total_devolucion,
                );
                return response()->json(['status' => 201, 'response' => $simulacionResponse], 201);
            } else {
                return response()->json(['status' => 500, 'error' => 'Error Interno'], 500);
            }
        } else {
            return response()->json(['status' => 404, 'error' => 'Cliente no encontrado'], 404);
        }
    }

    private function getCuotaHipoteca($tae, $plazo, $capital)
    {
        $i = ($tae / 100) / 12;
        $n = $plazo * 12;
        $cuota = $capital * $i / (1 - pow(1 + $i, -$n));
        return $cuota;
    }

    private function getImporteDevolucion($cuota, $plazo, $capital)
    {
        $importeTotal = $cuota * ($plazo * 12);
        return $importeTotal - $capital;
    }
}
