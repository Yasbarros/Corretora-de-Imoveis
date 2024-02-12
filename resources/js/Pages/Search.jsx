import React, { useState } from 'react'
import Layout from '@/Layouts/Layout'
import Card from '@/Components/Card'
import bannerImg from '/public/img/banner.jpg'
import { Link } from '@inertiajs/react'

const Search = ({properties,search}) => {
  const params = new URLSearchParams(window.location.search);

  const [modal, setModal] = useState(false)

  console.log(modal)

  const handleSubmit = () => {
    setModal(!modal)
  }

  return (
    <Layout>

      {modal && <div className="bg-black bg-opacity-70 flex items-center justify-center w-full h-full fixed z-50 top-0 left-0">
        <form onSubmit={() => handleSubmit()} className="bg-white p-8 rounded-md flex flex-col">
          <div className="flex justify-between mb-4">
            <span>Filtros de Pesquisa</span>
            <svg className="cursor-pointer" onClick={() => setModal(!modal)} width="25" height="25" viewBox="0 0 25 25" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path d="M18.5737 6.71472L6.57373 18.7147" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
              <path d="M6.57373 6.71472L18.5737 18.7147" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
          </div>
          <div className="flex gap-4 w-[900px]">
            <div className="w-1/5">
              <label className="border-b-2 border-black block mb-4 font-semibold" htmlFor="rooms">Quartos</label>
              <select name="rooms" id="rooms" className="w-full py-1">
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
                <option value="5">5</option>
              </select>
            </div>
            <div className="w-1/5">
              <label className="border-b-2 border-black block mb-4 font-semibold" htmlFor="bathrooms">Banheiros</label>
              <select name="bathrooms" id="bathrooms" className="w-full py-1">
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
                <option value="5">5</option>
              </select>
            </div>
            <div className="w-1/5">
              <label className="border-b-2 border-black block mb-4 font-semibold" htmlFor="isRent">Venda / Aluguel</label>
              <select name="isRent" id="isRent" className="w-full py-1">
                <option value="1">Venda</option>
                <option value="2">Aluguel</option>
              </select>
            </div>
            <div className="w-1/5">
              <label className="border-b-2 border-black block mb-4 font-semibold" htmlFor="value">Valor</label>
              <div className="flex gap-2">
                <span>Até:</span>
                <select name="value" id="value" className="w-full py-1">
                  <option value="50000">R$50.000</option>
                  <option value="100000">R$100.000</option>
                  <option value="200000">R$200.000</option>
                  <option value="300000">R$300.000</option>
                  <option value="400000">R$400.000</option>
                  <option value="500000">R$500.000</option>
                  <option value="1000000">R$1.000.000</option>
                </select>
              </div>
              
            </div>
            <div className="w-1/5">
            <label className="border-b-2 border-black block mb-4 font-semibold" htmlFor="isRent">Venda / Aluguel</label>
              <select name="isRent" id="isRent" className="w-full py-1">
                <option value="casa">Casa</option>
                <option value="apartamento">Apartamento</option>
              </select>
              
            </div>
            
          </div>
          <div className="flex justify-end mt-8">
            <button className="bg-main-color px-4 py-1">Aplicar</button>
          </div>


        </form>

      </div>}
      <div className="container">
        <div className="flex justify-between my-8">
          <h2><span className="font-semibold">Busca por:</span> {search}</h2>
          <div onClick={() => setModal(!modal)} className="flex px-4 py-1 bg-neutral-900 text-white cursor-pointer">
            <span>Filtros</span>
              <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M10.5 6H20.25M10.5 6C10.5 6.39782 10.342 6.77936 10.0607 7.06066C9.77936 7.34196 9.39782 7.5 9 7.5C8.60218 7.5 8.22064 7.34196 7.93934 7.06066C7.65804 6.77936 7.5 6.39782 7.5 6M10.5 6C10.5 5.60218 10.342 5.22064 10.0607 4.93934C9.77936 4.65804 9.39782 4.5 9 4.5C8.60218 4.5 8.22064 4.65804 7.93934 4.93934C7.65804 5.22064 7.5 5.60218 7.5 6M7.5 6H3.75M10.5 18H20.25M10.5 18C10.5 18.3978 10.342 18.7794 10.0607 19.0607C9.77936 19.342 9.39782 19.5 9 19.5C8.60218 19.5 8.22064 19.342 7.93934 19.0607C7.65804 18.7794 7.5 18.3978 7.5 18M10.5 18C10.5 17.6022 10.342 17.2206 10.0607 16.9393C9.77936 16.658 9.39782 16.5 9 16.5C8.60218 16.5 8.22064 16.658 7.93934 16.9393C7.65804 17.2206 7.5 17.6022 7.5 18M7.5 18H3.75M16.5 12H20.25M16.5 12C16.5 12.3978 16.342 12.7794 16.0607 13.0607C15.7794 13.342 15.3978 13.5 15 13.5C14.6022 13.5 14.2206 13.342 13.9393 13.0607C13.658 12.7794 13.5 12.3978 13.5 12M16.5 12C16.5 11.6022 16.342 11.2206 16.0607 10.9393C15.7794 10.658 15.3978 10.5 15 10.5C14.6022 10.5 14.2206 10.658 13.9393 10.9393C13.658 11.2206 13.5 11.6022 13.5 12M13.5 12H3.75" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
              </svg>
          </div>
        </div>

        <div className=" flex flex-col gap-4 md:gap-6 md:grid md:grid-cols-3 lg:grid-cols-4">
                    
              {properties && properties.length > 0 ? (
                  properties.map((property) => (
                      <Link key={property.id} href={`URL_DA_PAGINA_DA_PROPRIEDADE/${property.id}`}>
                          <Card
                              img={property.images[0]}
                              title={property.title}
                              value={property.price}
                              rooms={property.bedrooms}
                              bathrooms={property.bathrooms}
                          />
                      </Link>
                  ))
              ) : (
                  <div>
                      <h1 className='font-semibold mb-8'>Não encontrado</h1>
                  </div>
              )}
                      
          </div>
      </div>

    </Layout>
  )
}

export default Search