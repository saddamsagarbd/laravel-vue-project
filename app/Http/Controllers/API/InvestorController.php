<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Investor;

class InvestorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Investor::where('status', 1)->latest()->paginate(10);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'first_name' => 'required|string|max:30',
            'last_name' => 'required|string|max:30',
            'email' => 'required|string|email|max:191|unique:investors',
            'contact_no' => 'required|unique:investors',
            'nos_share' => 'required',
            'invst_amt' => 'required',
            'ref_no' => 'required',
            'address' => 'required',
        ]);

        return Investor::create([
            'first_name' => $request['first_name'],
            'last_name' => $request['last_name'],
            'email' => $request['email'],
            'contact_no' => $request['contact_no'],
            'nos_share' => $request['nos_share'],
            'invst_amt' => $request['invst_amt'],
            'ref_no' => $request['ref_no'],
            'address' => $request['address']
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $investor = Investor::findOrFail($id);

        $this->validate($request, [
            'first_name' => 'required|string|max:30',
            'last_name' => 'required|string|max:30',
            'email' => 'required|string|email|max:191|unique:investors,email,'.$investor->id,
            'contact_no' => 'required|unique:investors,contact_no,'.$investor->id,
            'nos_share' => 'required',
            'invst_amt' => 'required',
            'ref_no' => 'required',
            'address' => 'required',
        ]);

        $investor->update($request->all());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $investor = Investor::findOrFail($id);

        Investor::where('id', $id)
          ->update(['status' => 0]);
    }
}
