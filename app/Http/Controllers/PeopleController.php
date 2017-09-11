<?php

namespace App\Http\Controllers;

use Zttp\Zttp;
use App\Person;
use Illuminate\Http\Request;

class PeopleController extends Controller
{
    public function index()
    {
        $training_req = Zttp::withHeaders(['Ocp-Apim-Subscription-Key' => env('AZURE_KEY')])
                            ->get('https://eastus2.api.cognitive.microsoft.com/face/v1.0/persongroups/person-data/training');
        $training_resp = $training_req->json();
        // $response = Zttp::withHeaders(['Ocp-Apim-Subscription-Key' => env('AZURE_KEY')])
        //                 ->get('https://eastus2.api.cognitive.microsoft.com/face/v1.0/persongroups/person-data/persons?top=1000');
        return view('persons.index', ['persons' => Person::all(), 'status' => $training_resp['status']]);
    }

    public function validateData()
    {
        return Person::where(['dni' => request('dni'), 'birthday' => request('birthday')])->firstOrFail();
    }

    public function findByDocument()
    {
        return Person::whereMicrosoftPersonId(request('microsoftPersonId'))->firstOrFail();
    }

    public function create()
    {
        return view('persons.create');
    }

    public function store()
    {
        $response = Zttp::withHeaders(['Ocp-Apim-Subscription-Key' => env('AZURE_KEY')])
                        ->post('https://eastus2.api.cognitive.microsoft.com/face/v1.0/persongroups/person-data/persons', [
                            'name' => request('name'),
                            'userData' => request('dni'),
                        ]);

        return redirect('/person');
    }

    public function delete()
    {
        Zttp::withHeaders(['Ocp-Apim-Subscription-Key' => env('AZURE_KEY')])
            ->delete('https://eastus2.api.cognitive.microsoft.com/face/v1.0/persongroups/person-data/persons/' . request('person_id'));
        return redirect('/person');
    }

    public function showPhoto($person_id)
    {
        return view('persons.photo', ['person_id' => $person_id]);
    }

    public function storePhoto($person_id)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-type: application/octet-stream',
            'Ocp-Apim-Subscription-Key: '. env('AZURE_KEY'),
        ));
        curl_setopt($ch, CURLOPT_URL,'https://eastus2.api.cognitive.microsoft.com/face/v1.0/persongroups/person-data/persons/'.$person_id.'/persistedFaces');
        curl_setopt($ch, CURLOPT_POST,1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, file_get_contents(request()->file('photo')->getPathname()));
        $result = curl_exec($ch);
        curl_close($ch);

        return redirect('/person');
    }

    public function search()
    {
        return view('persons.search');
    }

    public function detect()
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-type: application/octet-stream',
            'Ocp-Apim-Subscription-Key: '. env('AZURE_KEY'),
        ));
        curl_setopt($ch, CURLOPT_URL,'https://eastus2.api.cognitive.microsoft.com/face/v1.0/detect?returnFaceId=true&returnFaceLandmarks=false');
        curl_setopt($ch, CURLOPT_POST,1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, file_get_contents(request()->file('photo')->getPathname()));
        $response = json_decode(curl_exec($ch), TRUE);
        curl_close($ch);

        $response = Zttp::withHeaders(['Ocp-Apim-Subscription-Key' => env('AZURE_KEY')])
                        ->post('https://eastus2.api.cognitive.microsoft.com/face/v1.0/identify', [
                            'personGroupId'  => 'person-data',
                            'faceIds'  => [ $response[0]['faceId'] ],
                            'maxNumOfCandidatesReturned' => 1,
                            'confidenceThreshold' => 0.5,
                        ]);
        $data = $response->json();
        if(count($data[0]['candidates']) > 0) {
            $response = Zttp::withHeaders(['Ocp-Apim-Subscription-Key' => env('AZURE_KEY')])
                            ->get('https://eastus2.api.cognitive.microsoft.com/face/v1.0/persongroups/person-data/persons/'.$data[0]['candidates'][0]['personId']);
            $person = $response->json();

            return redirect('/person')->with([
                'message' => "La persona es: {$person['name']} con DNI: {$person['userData']}",
            ]);
        }

        return redirect('/person')->with([
                'message' => 'No se ha encontrado una persona con tu foto',
            ]);
    }

    public function train()
    {
        Zttp::withHeaders(['Ocp-Apim-Subscription-Key' => env('AZURE_KEY')])
                        ->post('https://eastus2.api.cognitive.microsoft.com/face/v1.0/persongroups/person-data/train');

        return redirect('/person');
    }
    public function trainStatus()
    {
        $response = Zttp::withHeaders(['Ocp-Apim-Subscription-Key' => env('AZURE_KEY')])
                        ->get('https://eastus2.api.cognitive.microsoft.com/face/v1.0/persongroups/person-data/training');

        return $response->json();
    }
}
